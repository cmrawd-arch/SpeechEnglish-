<?php

namespace App\Models;

use App\Config\Database;
use PDO;

/**
 * Modèle Quiz — Gestion des quiz d'évaluation formative
 *
 * Règles de sécurité pédagogique :
 * - Aucune bonne réponse (`est_correcte`) n'est jamais exposée au navigateur
 *   avant que l'apprenant ne valide son choix.
 * - Les validations sont contrôlées et enregistrées côté serveur (MySQL + Session).
 */
class Quiz
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère un quiz par son identifiant avec les métadonnées de sa leçon et de son niveau.
     *
     * @param int $quizId
     * @return array|null
     */
    public function findById(int $quizId): ?array
    {
        $sql = "
            SELECT 
                q.id,
                q.lecon_id,
                q.titre,
                q.description,
                q.date_creation,
                l.titre AS lecon_titre,
                l.slug AS lecon_slug,
                l.ordre AS lecon_ordre,
                n.id AS niveau_id,
                n.code AS niveau_code,
                n.titre AS niveau_titre
            FROM quiz q
            JOIN lecons l ON q.lecon_id = l.id
            JOIN niveaux n ON l.niveau_id = n.id
            WHERE q.id = :qid
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['qid' => $quizId]);
        $quiz = $stmt->fetch();

        return $quiz ?: null;
    }

    /**
     * Récupère les questions d'un quiz pour l'affichage apprenant.
     * SÉCURITÉ : Ne retourne PAS les bonnes réponses ni les explications avant validation.
     *
     * @param int $quizId
     * @return array
     */
    public function getQuestionsForQuiz(int $quizId): array
    {
        $sql = "
            SELECT id, quiz_id, enonce, points, ordre
            FROM questions
            WHERE quiz_id = :qid
            ORDER BY ordre ASC, id ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['qid' => $quizId]);
        $questions = $stmt->fetchAll();

        foreach ($questions as &$question) {
            $question['propositions'] = $this->getOptionsForQuestion((int) $question['id']);
        }

        return $questions;
    }

    /**
     * Récupère les choix de réponses pour une question donnée.
     * SÉCURITÉ : La colonne `est_correcte` est STRICTEMENT EXCLUE de la requête.
     *
     * @param int $questionId
     * @return array
     */
    public function getOptionsForQuestion(int $questionId): array
    {
        $sql = "
            SELECT id, question_id, texte_reponse
            FROM propositions_reponses
            WHERE question_id = :qid
            ORDER BY id ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['qid' => $questionId]);
        return $stmt->fetchAll();
    }

    /**
     * Vérifie la réponse sélectionnée par l'utilisateur pour une question donnée.
     * Cette méthode compare avec MySQL et retourne :
     * - is_correct : booléen (vrai si bonne réponse)
     * - correct_option_id : identifiant de la bonne proposition
     * - explication : justification pédagogique de la règle
     * - points : points attribués
     *
     * @param int $questionId
     * @param int $selectedOptionId
     * @return array|null
     */
    public function verifyAnswer(int $questionId, int $selectedOptionId): ?array
    {
        // 1. Récupération de la question et de son explication pédagogique
        $qStmt = $this->db->prepare("
            SELECT id, quiz_id, enonce, explication, points 
            FROM questions 
            WHERE id = :qid 
            LIMIT 1
        ");
        $qStmt->execute(['qid' => $questionId]);
        $question = $qStmt->fetch();

        if (!$question) {
            return null;
        }

        // 2. Récupération de la bonne réponse pour cette question
        $correctStmt = $this->db->prepare("
            SELECT id, texte_reponse 
            FROM propositions_reponses 
            WHERE question_id = :qid AND est_correcte = 1 
            LIMIT 1
        ");
        $correctStmt->execute(['qid' => $questionId]);
        $correctOption = $correctStmt->fetch();

        $correctOptionId = $correctOption ? (int) $correctOption['id'] : 0;
        $isCorrect = ($selectedOptionId === $correctOptionId);

        // 3. Récupération de la proposition choisie pour vérification
        $chosenStmt = $this->db->prepare("
            SELECT id, texte_reponse 
            FROM propositions_reponses 
            WHERE id = :oid AND question_id = :qid 
            LIMIT 1
        ");
        $chosenStmt->execute(['oid' => $selectedOptionId, 'qid' => $questionId]);
        $chosenOption = $chosenStmt->fetch();

        if (!$chosenOption) {
            return null; // L'option sélectionnée n'appartient pas à cette question
        }

        return [
            'is_correct'         => $isCorrect,
            'correct_option_id'  => $correctOptionId,
            'selected_option_id' => $selectedOptionId,
            'explication'        => $question['explication'] ?? '',
            'points'             => (int) $question['points'],
            'points_gagnes'      => $isCorrect ? (int) $question['points'] : 0,
        ];
    }

    /**
     * Enregistre la tentative de quiz et le score final dans la table `tentatives_quiz`.
     *
     * @param int $userId
     * @param int $quizId
     * @param int $scoreObtenu
     * @param int $scoreMax
     * @param float $pourcentage
     * @return int Identifiant de la tentative créée
     */
    public function saveAttempt(int $userId, int $quizId, int $scoreObtenu, int $scoreMax, float $pourcentage): int
    {
        $sql = "
            INSERT INTO tentatives_quiz (utilisateur_id, quiz_id, score_obtenu, score_max, pourcentage, date_tentative)
            VALUES (:uid, :qid, :score, :smax, :pct, NOW())
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'uid'   => $userId,
            'qid'   => $quizId,
            'score' => $scoreObtenu,
            'smax'  => $scoreMax,
            'pct'   => $pourcentage,
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Récupère les données complètes d'une tentative de quiz pour la restitution des résultats.
     *
     * @param int $attemptId
     * @param int $userId
     * @return array|null
     */
    public function getAttemptDetails(int $attemptId, int $userId): ?array
    {
        $sql = "
            SELECT 
                t.id AS tentative_id,
                t.score_obtenu,
                t.score_max,
                t.pourcentage,
                t.date_tentative,
                q.id AS quiz_id,
                q.titre AS quiz_titre,
                q.description AS quiz_description,
                l.id AS lecon_id,
                l.titre AS lecon_titre,
                n.code AS niveau_code,
                n.titre AS niveau_titre
            FROM tentatives_quiz t
            JOIN quiz q ON t.quiz_id = q.id
            JOIN lecons l ON q.lecon_id = l.id
            JOIN niveaux n ON l.niveau_id = n.id
            WHERE t.id = :tid AND t.utilisateur_id = :uid
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['tid' => $attemptId, 'uid' => $userId]);
        $attempt = $stmt->fetch();

        return $attempt ?: null;
    }

    /**
     * Récupère le meilleur score d'un utilisateur sur un quiz donné.
     *
     * @param int $userId
     * @param int $quizId
     * @return array|null
     */
    public function getBestScore(int $userId, int $quizId): ?array
    {
        $sql = "
            SELECT score_obtenu, score_max, pourcentage, date_tentative
            FROM tentatives_quiz
            WHERE utilisateur_id = :uid AND quiz_id = :qid
            ORDER BY score_obtenu DESC, date_tentative DESC
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId, 'qid' => $quizId]);
        $res = $stmt->fetch();

        return $res ?: null;
    }
}

