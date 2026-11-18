<?php

/**
 * =============================================================================
 * Fonctions d'assistance globales (Helpers) — Speech English
 * =============================================================================
 */

/**
 * Échappe une chaîne pour prévenir les failles XSS.
 *
 * @param mixed $value
 * @return string
 */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Génère une URL absolue ou relative adaptée à l'environnement.
 *
 * @param string $path
 * @return string
 */
function url(string $path = ''): string
{
    // Détection automatique du sous-dossier dans XAMPP (ex: /SpeechEnglish/public)
    $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
    $base = ($scriptDir === '/' || $scriptDir === '\\') ? '' : rtrim($scriptDir, '/\\');
    
    $cleanPath = ltrim($path, '/');
    return $cleanPath === '' ? ($base ?: '/') : $base . '/' . $cleanPath;
}

/**
 * Redirige vers une URL et interrompt le script.
 *
 * @param string $path
 * @return void
 */
function redirect(string $path): void
{
    $targetUrl = str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
        ? $path
        : url($path);

    header("Location: {$targetUrl}");
    exit;
}

/**
 * Charge et affiche une vue avec extraction des données.
 *
 * @param string $view Nom de la vue (ex: 'auth/register')
 * @param array $data Données transmises à la vue
 * @return void
 */
function renderView(string $view, array $data = []): void
{
    // Sécurité : Empêcher la mise en cache des vues privées (pour la déconnexion)
    if (!empty($_SESSION['user_id'])) {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    extract($data);
    $viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $view) . '.php';

    if (!file_exists($viewPath)) {
        http_response_code(500);
        die("Erreur : La vue '{$view}' est introuvable.");
    }

    require $viewPath;
}

/**
 * Enregistre un message flash en session.
 *
 * @param string $type ('success', 'error', 'info', 'warning')
 * @param string $message
 * @return void
 */
function setFlash(string $type, string $message): void
{
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    $_SESSION['flash'][$type] = $message;
}

/**
 * Récupère et supprime un message flash de la session.
 *
 * @param string $type
 * @return string|null
 */
function getFlash(string $type): ?string
{
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    if (isset($_SESSION['flash'][$type])) {
        $msg = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $msg;
    }
    return null;
}

/**
 * Vérifie si un message flash existe.
 *
 * @param string $type
 * @return bool
 */
function hasFlash(string $type): bool
{
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    return !empty($_SESSION['flash'][$type]);
}

/**
 * Mémorise les données de formulaire soumises pour pré-remplissage.
 *
 * @param array $data
 * @return void
 */
function setOldInput(array $data): void
{
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    // Ne jamais conserver les mots de passe dans l'historique de saisie
    unset($data['mot_de_passe'], $data['mot_de_passe_confirm'], $data['password']);
    $_SESSION['old_input'] = $data;
}

/**
 * Récupère une ancienne valeur saisie et la nettoie.
 *
 * @param string $key
 * @param string $default
 * @return string
 */
function old(string $key, string $default = ''): string
{
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    $val = $_SESSION['old_input'][$key] ?? $default;
    return (string) $val;
}

/**
 * Nettoie les anciennes valeurs de saisie de la session.
 *
 * @return void
 */
function clearOldInput(): void
{
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    unset($_SESSION['old_input']);
}
