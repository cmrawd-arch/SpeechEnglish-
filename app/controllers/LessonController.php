<?php

namespace App\Controllers;

use App\Models\Lesson;
use App\Models\User;

/**
 * Contrôleur LessonController — Gestion de la consultation des cours de grammaire
 *
 * Permet aux apprenants :
 * - De consulter le catalogue des leçons structurées par les 3 niveaux (Easy, Basic, Hard).
 * - D'accéder au détail d'une leçon (Introduction, Explication, Règles, Exemples bilingues).
 * - De démarrer le quiz d'évaluation associé.
 */
class LessonController
{
    private Lesson $lessonModel;
    private User $userModel;

    public function __construct()
    {
        $this->lessonModel = new Lesson();
        $this->userModel = new User();
    }

    /**
     * Affiche l'ensemble des leçons classées par les 3 niveaux (Easy, Basic, Hard).
     */
    public function index(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            setFlash('error', "Veuillez vous connecter pour accéder à l'espace d'apprentissage.");
            redirect('/login');
        }

        $user = $this->userModel->findById((int) $userId);
        if (!$user) {
            session_destroy();
            redirect('/login');
        }

        // Récupération des niveaux avec leurs leçons réelles depuis MySQL
        $levels = $this->lessonModel->getAllGroupedByLevel((int) $userId);

        renderView('lessons/index', [
            'user'         => $user,
            'levels'       => $levels,
            'currentLevel' => 'all',
        ]);
    }

    /**
     * Filtre et affiche les leçons d'un niveau spécifique (ex: easy, basic, hard).
     *
     * @param string $code
     */
    public function byLevel(string $code): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            setFlash('error', "Veuillez vous connecter pour accéder aux leçons.");
            redirect('/login');
        }

        $user = $this->userModel->findById((int) $userId);
        if (!$user) {
            session_destroy();
            redirect('/login');
        }

        $level = $this->lessonModel->getByLevelCode($code, (int) $userId);
        if (!$level) {
            setFlash('error', "Le niveau demandé n'existe pas.");
            redirect('/lessons');
        }

        $levels = $this->lessonModel->getAllGroupedByLevel((int) $userId);

        renderView('lessons/index', [
            'user'          => $user,
            'levels'        => $levels,
            'currentLevel'  => strtolower($code),
            'selectedLevel' => $level,
        ]);
    }

    /**
     * Affiche une fiche de leçon complète avec tous ses blocs pédagogiques.
     *
     * @param int $id
     */
    public function show(int $id): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            setFlash('error', "Veuillez vous connecter pour consulter cette leçon.");
            redirect('/login');
        }

        $user = $this->userModel->findById((int) $userId);
        if (!$user) {
            session_destroy();
            redirect('/login');
        }

        $lesson = $this->lessonModel->findById($id, (int) $userId);
        if (!$lesson) {
            setFlash('error', "La leçon demandée est introuvable.");
            redirect('/lessons');
        }

        // Mise à jour de la progression de l'utilisateur : statut 'en_cours'
        $this->lessonModel->markAsViewed((int) $userId, $id);

        renderView('lessons/show', [
            'user'   => $user,
            'lesson' => $lesson,
        ]);
    }
}

