<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\DashboardModel;

/**
 * Contrôleur UserController — Gestion du Tableau de bord et de l'espace apprenant
 */
class UserController
{
    private User $userModel;
    private DashboardModel $dashboardModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->dashboardModel = new DashboardModel();
    }

    /**
     * Affiche le tableau de bord de l'utilisateur connecté avec ses données réelles depuis MySQL.
     */
    public function dashboard(): void
    {
        // 1. Vérification de la session utilisateur
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            setFlash('error', "Veuillez vous connecter pour accéder à votre tableau de bord personnel.");
            redirect('/login');
        }

        // 2. Récupération des informations réelles de l'utilisateur depuis MySQL
        $user = $this->userModel->findById((int) $userId);

        if (!$user) {
            // Utilisateur introuvable en BDD (ex: supprimé)
            session_destroy();
            redirect('/login');
        }

        // 3. Récupération des statistiques réelles (aucun chiffre inventé)
        $stats       = $this->dashboardModel->getUserStats($user['id']);
        $latestScore = $this->dashboardModel->getLatestScore($user['id']);
        $levels      = $this->dashboardModel->getLevelsWithDetails($user['id']);
        $history     = $this->dashboardModel->getQuizHistory($user['id'], 6);
        $welcomeMsg  = getFlash('welcome');

        // 4. Transmission à la vue du tableau de bord
        renderView('dashboard/index', [
            'user'        => $user,
            'stats'       => $stats,
            'latestScore' => $latestScore,
            'levels'      => $levels,
            'history'     => $history,
            'welcomeMsg'  => $welcomeMsg,
        ]);
    }
}

