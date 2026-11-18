<?php

namespace App\Models;

use App\Config\Database;
use PDO;

/**
 * Modèle DashboardModel — Récupération des données réelles du tableau de bord depuis MySQL
 * 
 * Aucune donnée fictive : tous les chiffres (scores, progression, quiz réalisés)
 * sont calculés directement à partir des enregistrements réels de la BDD.
 */
class DashboardModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère les métriques réelles de progression et d'activité de l'utilisateur.
     *
     * @param int $userId Identifiant de l'utilisateur connecté
     * @return array
     */
    public function getUserStats(int $userId): array
    {
        // 1. Total des quiz existants dans l'application
        $stmt = $this->db->query("SELECT COUNT(*) FROM quiz");
        $totalQuizzesApp = (int) $stmt->fetchColumn();

        // 2. Nombre total de tentatives de quiz réalisées par l'utilisateur
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tentatives_quiz WHERE utilisateur_id = :uid");
        $stmt->execute(['uid' => $userId]);
        $totalAttempts = (int) $stmt->fetchColumn();

        // 3. Nombre de quiz distincts complétés/validés par l'utilisateur
        $stmt = $this->db->prepare("SELECT COUNT(DISTINCT quiz_id) FROM tentatives_quiz WHERE utilisateur_id = :uid");
        $stmt->execute(['uid' => $userId]);
        $quizzesCompleted = (int) $stmt->fetchColumn();

        // 4. Total des leçons disponibles dans l'application
        $stmt = $this->db->query("SELECT COUNT(*) FROM lecons");
        $totalLessonsApp = (int) $stmt->fetchColumn();

        // 5. Nombre de leçons terminées par l'utilisateur
        $stmt = $this->db->prepare("
            SELECT COUNT(DISTINCT lecon_id) 
            FROM progression_lecons 
            WHERE utilisateur_id = :uid AND statut = 'termine'
        ");
        $stmt->execute(['uid' => $userId]);
        $lessonsCompleted = (int) $stmt->fetchColumn();

        // 6. Calcul réel de la progression globale (en pourcentage basé sur les quiz complétés)
        $progressionPercent = $totalQuizzesApp > 0 
            ? round(($quizzesCompleted / $totalQuizzesApp) * 100) 
            : 0;

        // 7. Score moyen réel en pourcentage
        $stmt = $this->db->prepare("SELECT AVG(pourcentage) FROM tentatives_quiz WHERE utilisateur_id = :uid");
        $stmt->execute(['uid' => $userId]);
        $avgScore = $stmt->fetchColumn();
        $averageScore = $avgScore !== null ? round((float) $avgScore, 1) : null;

        return [
            'total_quizzes_app'     => $totalQuizzesApp,
            'total_attempts'        => $totalAttempts,
            'quizzes_completed'     => $quizzesCompleted,
            'total_lessons_app'     => $totalLessonsApp,
            'lessons_completed'     => $lessonsCompleted,
            'progression_percent'   => $progressionPercent,
            'average_score'         => $averageScore,
        ];
    }

    /**
     * Récupère le dernier score obtenu par l'utilisateur (le plus récent).
     *
     * @param int $userId
     * @return array|null
     */
    public function getLatestScore(int $userId): ?array
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
                l.id AS lecon_id,
                l.titre AS lecon_titre,
                n.code AS niveau_code,
                n.titre AS niveau_titre
            FROM tentatives_quiz t
            JOIN quiz q ON t.quiz_id = q.id
            JOIN lecons l ON q.lecon_id = l.id
            JOIN niveaux n ON l.niveau_id = n.id
            WHERE t.utilisateur_id = :uid
            ORDER BY t.date_tentative DESC, t.id DESC
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    /**
     * Récupère les 3 niveaux (Easy, Basic, Hard) avec leur progression réelle et leurs leçons.
     *
     * @param int $userId
     * @return array
     */
    public function getLevelsWithDetails(int $userId): array
    {
        $levelsStmt = $this->db->query("SELECT * FROM niveaux ORDER BY ordre ASC");
        $levels = $levelsStmt->fetchAll();

        foreach ($levels as &$lvl) {
            $nid = (int) $lvl['id'];

            // 1. Liste des leçons et quiz associés à ce niveau
            $lessonsStmt = $this->db->prepare("
                SELECT 
                    l.id AS lecon_id,
                    l.titre AS lecon_titre,
                    l.slug AS lecon_slug,
                    l.ordre AS lecon_ordre,
                    q.id AS quiz_id,
                    q.titre AS quiz_titre,
                    COALESCE(pl.statut, 'non_commence') AS user_statut,
                    (
                        SELECT t.pourcentage 
                        FROM tentatives_quiz t 
                        WHERE t.quiz_id = q.id AND t.utilisateur_id = :uid1 
                        ORDER BY t.date_tentative DESC, t.id DESC 
                        LIMIT 1
                    ) AS user_last_score
                FROM lecons l
                LEFT JOIN quiz q ON l.id = q.lecon_id
                LEFT JOIN progression_lecons pl ON l.id = pl.lecon_id AND pl.utilisateur_id = :uid2
                WHERE l.niveau_id = :nid
                ORDER BY l.ordre ASC
            ");
            $lessonsStmt->execute(['nid' => $nid, 'uid1' => $userId, 'uid2' => $userId]);
            $lvl['lessons'] = $lessonsStmt->fetchAll();

            // 2. Calcul réel de la progression pour ce niveau
            $totalInLevel = count($lvl['lessons']);
            $completedInLevel = 0;

            foreach ($lvl['lessons'] as $les) {
                // Une leçon est comptée complétée si elle est marquée 'termine' ou si le quiz associé a été passé
                if ($les['user_statut'] === 'termine' || $les['user_last_score'] !== null) {
                    $completedInLevel++;
                }
            }

            $lvl['total_lessons'] = $totalInLevel;
            $lvl['completed_lessons'] = $completedInLevel;
            $lvl['progress_percent'] = $totalInLevel > 0 
                ? round(($completedInLevel / $totalInLevel) * 100) 
                : 0;
        }

        return $levels;
    }

    /**
     * Récupère l'historique complet ou récent des quiz réalisés par l'utilisateur.
     *
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getQuizHistory(int $userId, int $limit = 5): array
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
                l.id AS lecon_id,
                l.titre AS lecon_titre,
                n.code AS niveau_code,
                n.titre AS niveau_titre
            FROM tentatives_quiz t
            JOIN quiz q ON t.quiz_id = q.id
            JOIN lecons l ON q.lecon_id = l.id
            JOIN niveaux n ON l.niveau_id = n.id
            WHERE t.utilisateur_id = :uid
            ORDER BY t.date_tentative DESC, t.id DESC
            LIMIT " . (int) $limit;

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }
}
