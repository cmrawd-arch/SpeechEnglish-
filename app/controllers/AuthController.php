<?php

namespace App\Controllers;

use App\Models\User;

/**
 * Contrôleur AuthController — Gestion de l'inscription et de l'authentification
 */
class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Affiche le formulaire d'inscription.
     */
    public function showRegister(): void
    {
        // Récupération des erreurs et messages stockés en session
        $errors = $_SESSION['register_errors'] ?? [];
        $success = getFlash('success');
        unset($_SESSION['register_errors']);

        renderView('auth/register', [
            'errors'  => $errors,
            'success' => $success,
        ]);

        // Nettoyage des anciennes valeurs de formulaire une fois affichées
        clearOldInput();
    }

    /**
     * Traite la soumission du formulaire d'inscription avec validations serveur.
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/register');
        }

        // 1. Récupération et nettoyage préliminaire des champs
        $nom                 = trim($_POST['nom'] ?? '');
        $prenom              = trim($_POST['prenom'] ?? '');
        $email               = trim($_POST['email'] ?? '');
        $motDePasse          = $_POST['mot_de_passe'] ?? '';
        $motDePasseConfirm   = $_POST['mot_de_passe_confirm'] ?? '';

        // Sauvegarde des saisies utilisateur (sauf mots de passe) pour réaffichage en cas d'erreur
        setOldInput([
            'nom'    => $nom,
            'prenom' => $prenom,
            'email'  => $email,
        ]);

        $errors = [];

        // 2. Validation des champs obligatoires
        if ($nom === '') {
            $errors['nom'] = "Le nom est obligatoire.";
        } elseif (mb_strlen($nom) < 2) {
            $errors['nom'] = "Le nom doit comporter au moins 2 caractères.";
        }

        if ($prenom === '') {
            $errors['prenom'] = "Le prénom est obligatoire.";
        } elseif (mb_strlen($prenom) < 2) {
            $errors['prenom'] = "Le prénom doit comporter au moins 2 caractères.";
        }

        // 3. Validation de l'adresse email
        if ($email === '') {
            $errors['email'] = "L'adresse email est obligatoire.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Veuillez saisir une adresse email valide (ex. nom@exemple.com).";
        } elseif ($this->userModel->emailExists($email)) {
            // 4. Validation de l'unicité de l'adresse email
            $errors['email'] = "Cette adresse email est déjà associée à un compte existant.";
        }

        // 5. Validation du mot de passe
        if ($motDePasse === '') {
            $errors['mot_de_passe'] = "Le mot de passe est obligatoire.";
        } elseif (strlen($motDePasse) < 6) {
            $errors['mot_de_passe'] = "Le mot de passe doit contenir au moins 6 caractères.";
        }

        // 6. Validation de la confirmation du mot de passe
        if ($motDePasseConfirm === '') {
            $errors['mot_de_passe_confirm'] = "La confirmation du mot de passe est obligatoire.";
        } elseif ($motDePasse !== $motDePasseConfirm) {
            $errors['mot_de_passe_confirm'] = "Les deux mots de passe ne correspondent pas.";
        }

        // 7. En cas d'erreurs de validation, retour au formulaire
        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;
            redirect('/register');
        }

        // 8. Enregistrement en base de données avec hachage sécurisé
        try {
            $this->userModel->create($nom, $prenom, $email, $motDePasse);

            // Message de succès invitant l'utilisateur à se connecter
            setFlash(
                'success',
                "Félicitations {$prenom} ! Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter pour commencer vos leçons."
            );

            // Nettoyage de l'historique de formulaire après succès
            clearOldInput();

            // Redirection vers la page avec notification et bouton de connexion
            redirect('/register');
        } catch (\Throwable $e) {
            error_log("[Registration Error] " . $e->getMessage());
            $_SESSION['register_errors'] = [
                'general' => "Une erreur technique est survenue lors de l'enregistrement. Veuillez réessayer ultérieurement."
            ];
            redirect('/register');
        }
    }

    /**
     * Affiche l'écran de connexion (pour répondre à la proposition de connexion).
     */
    public function showLogin(): void
    {
        $success = getFlash('success');
        $error = getFlash('error');

        renderView('auth/login', [
            'success' => $success,
            'error'   => $error,
        ]);
    }

    /**
     * Traite la soumission du formulaire de connexion.
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/login');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            setFlash('error', 'Veuillez saisir votre adresse email et votre mot de passe.');
            redirect('/login');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['mot_de_passe'])) {
            setFlash('error', 'Identifiants incorrects. Veuillez vérifier votre email et mot de passe.');
            redirect('/login');
        }

        // Régénération sécurisée de la session
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['user_prenom'] = $user['prenom'];
        $_SESSION['user_email'] = $user['email'];

        setFlash('welcome', "Ravi de vous revoir, {$user['prenom']} !");
        redirect('/dashboard');
    }

    /**
     * Déconnecte l'utilisateur en détruisant sa session.
     */
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        redirect('/login');
    }
}

