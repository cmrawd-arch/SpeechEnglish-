<?php

namespace App\Models;

use App\Config\Database;
use PDO;

/**
 * Modèle Lesson — Gestion des cours et fiches de grammaire
 * 
 * Les leçons sont classées selon les 3 niveaux pédagogiques :
 * - Easy (débutant)
 * - Basic (intermédiaire)
 * - Hard (avancé)
 */
class Lesson
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Récupère toutes les leçons groupées par niveau d'apprentissage.
     *
     * @param int|null $userId Identifiant de l'utilisateur pour joindre le statut et le score
     * @return array
     */
    public function getAllGroupedByLevel(?int $userId = null): array
    {
        // 1. Récupération des 3 niveaux
        $levelsStmt = $this->db->query("SELECT * FROM niveaux ORDER BY ordre ASC");
        $levels = $levelsStmt->fetchAll();

        foreach ($levels as &$level) {
            $levelId = (int) $level['id'];

            if ($userId !== null) {
                $sql = "
                    SELECT 
                        l.id,
                        l.niveau_id,
                        l.titre,
                        l.slug,
                        l.contenu,
                        l.ordre,
                        l.date_creation,
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
                ";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    'nid'  => $levelId,
                    'uid1' => $userId,
                    'uid2' => $userId,
                ]);
            } else {
                $sql = "
                    SELECT 
                        l.id,
                        l.niveau_id,
                        l.titre,
                        l.slug,
                        l.contenu,
                        l.ordre,
                        l.date_creation,
                        q.id AS quiz_id,
                        q.titre AS quiz_titre,
                        'non_commence' AS user_statut,
                        NULL AS user_last_score
                    FROM lecons l
                    LEFT JOIN quiz q ON l.id = q.lecon_id
                    WHERE l.niveau_id = :nid
                    ORDER BY l.ordre ASC
                ";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(['nid' => $levelId]);
            }

            $level['lessons'] = $stmt->fetchAll();
        }

        return $levels;
    }

    /**
     * Récupère un niveau par son code ('easy', 'basic', 'hard') et l'ensemble de ses leçons.
     *
     * @param string $code
     * @param int|null $userId
     * @return array|null
     */
    public function getByLevelCode(string $code, ?int $userId = null): ?array
    {
        $code = strtolower(trim($code));
        $stmt = $this->db->prepare("SELECT * FROM niveaux WHERE LOWER(code) = :code LIMIT 1");
        $stmt->execute(['code' => $code]);
        $level = $stmt->fetch();

        if (!$level) {
            return null;
        }

        $levelId = (int) $level['id'];

        if ($userId !== null) {
            $sql = "
                SELECT 
                    l.id,
                    l.niveau_id,
                    l.titre,
                    l.slug,
                    l.contenu,
                    l.ordre,
                    l.date_creation,
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
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'nid'  => $levelId,
                'uid1' => $userId,
                'uid2' => $userId,
            ]);
        } else {
            $sql = "
                SELECT 
                    l.id,
                    l.niveau_id,
                    l.titre,
                    l.slug,
                    l.contenu,
                    l.ordre,
                    l.date_creation,
                    q.id AS quiz_id,
                    q.titre AS quiz_titre,
                    'non_commence' AS user_statut,
                    NULL AS user_last_score
                FROM lecons l
                LEFT JOIN quiz q ON l.id = q.lecon_id
                WHERE l.niveau_id = :nid
                ORDER BY l.ordre ASC
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['nid' => $levelId]);
        }

        $level['lessons'] = $stmt->fetchAll();
        return $level;
    }

    /**
     * Récupère une leçon spécifique par son identifiant avec les infos de son niveau et du quiz associé.
     *
     * @param int $lessonId
     * @param int|null $userId
     * @return array|null
     */
    public function findById(int $lessonId, ?int $userId = null): ?array
    {
        $sql = "
            SELECT 
                l.id,
                l.niveau_id,
                l.titre,
                l.slug,
                l.contenu,
                l.ordre,
                l.date_creation,
                n.code AS niveau_code,
                n.titre AS niveau_titre,
                n.description AS niveau_description,
                q.id AS quiz_id,
                q.titre AS quiz_titre,
                q.description AS quiz_description
            FROM lecons l
            JOIN niveaux n ON l.niveau_id = n.id
            LEFT JOIN quiz q ON l.id = q.lecon_id
            WHERE l.id = :lid
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['lid' => $lessonId]);
        $lesson = $stmt->fetch();

        if (!$lesson) {
            return null;
        }

        // Si utilisateur connecté, récupérer son statut et score
        if ($userId !== null) {
            $progStmt = $this->db->prepare("
                SELECT statut, date_derniere_consultation, date_completion 
                FROM progression_lecons 
                WHERE utilisateur_id = :uid AND lecon_id = :lid 
                LIMIT 1
            ");
            $progStmt->execute(['uid' => $userId, 'lid' => $lessonId]);
            $prog = $progStmt->fetch();

            $lesson['user_statut'] = $prog['statut'] ?? 'non_commence';
            $lesson['date_completion'] = $prog['date_completion'] ?? null;

            if (!empty($lesson['quiz_id'])) {
                $scoreStmt = $this->db->prepare("
                    SELECT score_obtenu, score_max, pourcentage, date_tentative
                    FROM tentatives_quiz
                    WHERE utilisateur_id = :uid AND quiz_id = :qid
                    ORDER BY date_tentative DESC, id DESC
                    LIMIT 1
                ");
                $scoreStmt->execute(['uid' => $userId, 'qid' => $lesson['quiz_id']]);
                $lesson['user_last_score'] = $scoreStmt->fetch() ?: null;
            } else {
                $lesson['user_last_score'] = null;
            }
        } else {
            $lesson['user_statut'] = 'non_commence';
            $lesson['date_completion'] = null;
            $lesson['user_last_score'] = null;
        }

        // Récupérer la leçon précédente et suivante dans le même niveau pour une navigation fluide
        $lesson['previous_lesson'] = $this->getNeighborLesson((int) $lesson['niveau_id'], (int) $lesson['ordre'], 'prev');
        $lesson['next_lesson'] = $this->getNeighborLesson((int) $lesson['niveau_id'], (int) $lesson['ordre'], 'next');

        return $lesson;
    }

    /**
     * Récupère la leçon voisine (précédente ou suivante) dans un niveau.
     *
     * @param int $niveauId
     * @param int $currentOrder
     * @param string $direction 'prev' ou 'next'
     * @return array|null
     */
    private function getNeighborLesson(int $niveauId, int $currentOrder, string $direction): ?array
    {
        if ($direction === 'prev') {
            $sql = "
                SELECT id, titre, slug 
                FROM lecons 
                WHERE niveau_id = :nid AND ordre < :ord 
                ORDER BY ordre DESC 
                LIMIT 1
            ";
        } else {
            $sql = "
                SELECT id, titre, slug 
                FROM lecons 
                WHERE niveau_id = :nid AND ordre > :ord 
                ORDER BY ordre ASC 
                LIMIT 1
            ";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['nid' => $niveauId, 'ord' => $currentOrder]);
        $neighbor = $stmt->fetch();

        return $neighbor ?: null;
    }

    /**
     * Enregistre ou met à jour la progression d'une leçon pour un utilisateur.
     * Si la leçon n'était pas encore commencée, elle passe en 'en_cours'.
     *
     * @param int $userId
     * @param int $lessonId
     * @return void
     */
    public function markAsViewed(int $userId, int $lessonId): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO progression_lecons (utilisateur_id, lecon_id, statut, date_derniere_consultation)
            VALUES (:uid, :lid, 'en_cours', NOW())
            ON DUPLICATE KEY UPDATE 
                date_derniere_consultation = NOW(),
                statut = IF(statut = 'termine', 'termine', 'en_cours')
        ");
        $stmt->execute(['uid' => $userId, 'lid' => $lessonId]);
    }

    /**
     * Marque définitivement une leçon comme terminée.
     *
     * @param int $userId
     * @param int $lessonId
     * @return void
     */
    public function markAsCompleted(int $userId, int $lessonId): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO progression_lecons (utilisateur_id, lecon_id, statut, date_derniere_consultation, date_completion)
            VALUES (:uid, :lid, 'termine', NOW(), NOW())
            ON DUPLICATE KEY UPDATE 
                statut = 'termine',
                date_derniere_consultation = NOW(),
                date_completion = IF(date_completion IS NULL, NOW(), date_completion)
        ");
        $stmt->execute(['uid' => $userId, 'lid' => $lessonId]);
    }
}

