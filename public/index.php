<?php

/**
 * =============================================================================
 * Speech English — Front Controller & Routeur d'application
 * =============================================================================
 */

// Initialisation de la session utilisateur
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Chargement des fonctions d'assistance (Helpers)
require_once dirname(__DIR__) . '/app/helpers/functions.php';

// 2. Chargement de l'autoloader Composer s'il existe
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}

// 3. Autoloader PSR-4 natif pour l'architecture App\
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = dirname(__DIR__) . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\LessonController;
use App\Controllers\QuizController;

// 4. Normalisation de la route demandée (gestion du sous-dossier XAMPP)
$requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$scriptName = dirname($_SERVER['SCRIPT_NAME'] ?? '');

if ($scriptName !== '/' && $scriptName !== '\\' && str_starts_with($requestUri, $scriptName)) {
    $route = substr($requestUri, strlen($scriptName));
} else {
    $route = $requestUri;
}

$route = '/' . trim($route, '/');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// 5. Instanciation des contrôleurs
$authController   = new AuthController();
$userController   = new UserController();
$lessonController = new LessonController();
$quizController   = new QuizController();

// 6. Table de routage dynamique
// Routes statiques principales
if ($route === '/' || $route === '') {
    if (!empty($_SESSION['user_id'])) {
        redirect('/dashboard');
    } else {
        $authController->showRegister();
    }
    exit;
}

if ($route === '/register') {
    if ($method === 'POST') {
        $authController->register();
    } else {
        $authController->showRegister();
    }
    exit;
}

if ($route === '/login') {
    if ($method === 'POST') {
        $authController->login();
    } else {
        $authController->showLogin();
    }
    exit;
}

if ($route === '/logout') {
    $authController->logout();
    exit;
}

if ($route === '/dashboard') {
    $userController->dashboard();
    exit;
}

if ($route === '/lessons') {
    $lessonController->index();
    exit;
}

// Routes paramétrées avec expressions régulières

// A. Niveau spécifique : /levels/{code} (ex: /levels/easy)
if (preg_match('#^/levels/([a-zA-Z0-9_-]+)$#', $route, $matches)) {
    $lessonController->byLevel($matches[1]);
    exit;
}

// B. Consultation d'une leçon : /lessons/{id} (ex: /lessons/1)
if (preg_match('#^/lessons/(\d+)$#', $route, $matches)) {
    $lessonController->show((int) $matches[1]);
    exit;
}

// C. Validation d'une question de quiz (POST) : /quiz/{id}/validate
if (preg_match('#^/quiz/(\d+)/validate$#', $route, $matches)) {
    if ($method === 'POST') {
        $quizController->validateAnswer((int) $matches[1]);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée. Utilisez POST.']);
    }
    exit;
}

// D. Clôture d'un quiz (POST) : /quiz/{id}/finish
if (preg_match('#^/quiz/(\d+)/finish$#', $route, $matches)) {
    if ($method === 'POST') {
        $quizController->finish((int) $matches[1]);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée. Utilisez POST.']);
    }
    exit;
}

// E. Affichage du quiz interactif : /quiz/{id} (ex: /quiz/1)
if (preg_match('#^/quiz/(\d+)$#', $route, $matches)) {
    $quizController->show((int) $matches[1]);
    exit;
}

// F. Page de résultat / bilan : /results/{attemptId} (ex: /results/3)
if (preg_match('#^/results/(\d+)$#', $route, $matches)) {
    $quizController->result((int) $matches[1]);
    exit;
}

// 7. Route non trouvée (404)
http_response_code(404);
echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='utf-8'>
    <title>404 — Page introuvable | Speech English</title>
    <link rel='stylesheet' href='" . url('/assets/css/style.css') . "'>
</head>
<body class='dashboard-body' style='display:flex;align-items:center;justify-content:center;min-height:100vh;'>
    <div class='auth-card text-center' style='max-width:500px;'>
        <div style='font-size:3.5rem;'>🧭</div>
        <h1 style='color:#14213d;font-size:1.8rem;margin:1rem 0;'>Page non trouvée (404)</h1>
        <p style='color:#6c757d;line-height:1.6;'>L'adresse demandée n'existe pas ou la ressource a été déplacée.</p>
        <div style='margin-top:1.5rem;'>
            <a href='" . url('/dashboard') . "' class='btn btn-primary'>&larr; Retour au tableau de bord</a>
        </div>
    </div>
</body>
</html>";
