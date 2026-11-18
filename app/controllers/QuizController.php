<?php

namespace App\Controllers;

use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\User;

/**
 * Contrôleur QuizController — Gestion du cycle d'évaluation formative
 *
 * Implémentation stricte des règles de sécurité :
 * 1. La bonne réponse n'est jamais exposée au navigateur avant validation.
 * 2. Une fois une réponse validée, elle est verrouillée en session et en BDD.
 * 3. Enregistrement automatique du score et mise à jour de la progression en fin de quiz.
 */
class QuizController
{
    private Quiz $quizModel;
    private Lesson $lessonModel;
    private User $userModel;

    public function __construct()
    {
        $this->quizModel = new Quiz();
        $this->lessonModel = new Lesson();
        $this->userModel = new User();
    }

    /**
     * Affiche l'interface interactive du quiz et initialise la session d'évaluation.
     *
     * @param int $quizId
     */
    public function show(int $quizId): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            setFlash('error', "Veuillez vous connecter pour participer au quiz.");
            redirect('/login');
        }

        $user = $this->userModel->findById((int) $userId);
        if (!$user) {
            session_destroy();
            redirect('/login');
        }

        // Récupération des informations du quiz
        $quiz = $this->quizModel->findById($quizId);
        if (!$quiz) {
            setFlash('error', "Le quiz demandé est introuvable.");
            redirect('/dashboard');
        }

        // Récupération des questions et des propositions (SANS les réponses correctes)
        $questions = $this->quizModel->getQuestionsForQuiz($quizId);
        if (empty($questions)) {
            setFlash('warning', "Ce quiz ne contient aucune question pour le moment.");
            redirect('/lessons/' . $quiz['lecon_id']);
        }

        // Initialisation de la session d'évaluation pour garantir l'intégrité du parcours
        $questionIds = array_map(fn($q) => (int) $q['id'], $questions);
        $maxScore = array_sum(array_map(fn($q) => (int) ($q['points'] ?? 1), $questions));

        $_SESSION['active_quiz'][$quizId] = [
            'quiz_id'      => $quizId,
            'lecon_id'     => (int) $quiz['lecon_id'],
            'user_id'      => (int) $userId,
            'question_ids' => $questionIds,
            'total'        => count($questions),
            'max_score'    => $maxScore,
            'score'        => 0,
            'answers'      => [], // Format : [question_id => ['selected_option_id' => ..., 'is_correct' => ...]]
            'started_at'   => time(),
        ];

        // Meilleur score précédent s'il existe
        $bestScore = $this->quizModel->getBestScore((int) $userId, $quizId);

        renderView('quizzes/show', [
            'user'       => $user,
            'quiz'       => $quiz,
            'questions'  => $questions,
            'bestScore'  => $bestScore,
        ]);
    }

    /**
     * Valide la réponse de l'utilisateur pour une question spécifique.
     * Endpoint API POST : /quiz/{id}/validate
     *
     * Règles :
     * - Compare côté serveur avec la bonne réponse stockée dans MySQL.
     * - Interdit strictement de modifier une réponse déjà validée.
     * - Renvoie la correction immédiate et l'explication pédagogique.
     *
     * @param int $quizId
     */
    public function validateAnswer(int $quizId): void
    {
        // Envoi des en-têtes JSON
        header('Content-Type: application/json; charset=utf-8');

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Non authentifié.']);
            exit;
        }

        // Vérification de la session active du quiz
        if (!isset($_SESSION['active_quiz'][$quizId])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Session de quiz expirée ou invalide. Veuillez recommencer le quiz.']);
            exit;
        }

        // Récupération des données POST (form-encoded ou JSON)
        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true);

        $questionId = (int) ($jsonData['question_id'] ?? $_POST['question_id'] ?? 0);
        $optionId   = (int) ($jsonData['option_id'] ?? $_POST['option_id'] ?? 0);

        if ($questionId <= 0 || $optionId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Question ou proposition invalide.']);
            exit;
        }

        $sessionQuiz = &$_SESSION['active_quiz'][$quizId];

        // 1. Contrôle : la question appartient-elle bien au quiz actif ?
        if (!in_array($questionId, $sessionQuiz['question_ids'], true)) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Cette question n\'appartient pas à ce quiz.']);
            exit;
        }

        // 2. RÈGLE CRITIQUE : L'utilisateur ne doit pas pouvoir modifier une réponse après validation
        if (isset($sessionQuiz['answers'][$questionId])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error'   => 'Cette question a déjà été validée. Vous ne pouvez plus modifier votre réponse.',
            ]);
            exit;
        }

        // 3. Comparaison serveur avec MySQL
        $verification = $this->quizModel->verifyAnswer($questionId, $optionId);

        if (!$verification) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Proposition inconnue ou incompatible avec cette question.']);
            exit;
        }

        // 4. Enregistrement irrévocable de la réponse dans la session
        $sessionQuiz['answers'][$questionId] = [
            'selected_option_id' => $optionId,
            'is_correct'         => $verification['is_correct'],
            'points_gagnes'      => $verification['points_gagnes'],
            'answered_at'        => time(),
        ];

        // Mise à jour du score cumulé
        $sessionQuiz['score'] += $verification['points_gagnes'];

        $answeredCount = count($sessionQuiz['answers']);
        $totalQuestions = $sessionQuiz['total'];
        $isLastQuestion = ($answeredCount >= $totalQuestions);

        // 5. Réponse sécurisée : révélation de la correction UNIQUEMENT après validation
        echo json_encode([
            'success'            => true,
            'question_id'        => $questionId,
            'selected_option_id' => $optionId,
            'is_correct'         => $verification['is_correct'],
            'correct_option_id'  => $verification['correct_option_id'],
            'explication'        => $verification['explication'],
            'points_gagnes'      => $verification['points_gagnes'],
            'current_score'      => $sessionQuiz['score'],
            'max_score'          => $sessionQuiz['max_score'],
            'answered_count'     => $answeredCount,
            'total_questions'    => $totalQuestions,
            'is_last_question'   => $isLastQuestion,
        ]);
        exit;
    }

    /**
     * Clôture le quiz, calcule le score final, l'enregistre en base MySQL
     * et met à jour la progression de la leçon.
     * Endpoint API POST : /quiz/{id}/finish
     *
     * @param int $quizId
     */
    public function finish(int $quizId): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Non authentifié.']);
            exit;
        }

        if (!isset($_SESSION['active_quiz'][$quizId])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Session de quiz inexistante ou déjà clôturée.']);
            exit;
        }

        $sessionQuiz = $_SESSION['active_quiz'][$quizId];
        $scoreObtenu = (int) $sessionQuiz['score'];
        $scoreMax    = (int) $sessionQuiz['max_score'];
        $leconId     = (int) $sessionQuiz['lecon_id'];

        // Calcul des statistiques détaillées (bonnes/mauvaises réponses)
        $bonnes = 0;
        $mauvaises = 0;
        foreach ($sessionQuiz['answers'] as $ans) {
            if ($ans['is_correct']) {
                $bonnes++;
            } else {
                $mauvaises++;
            }
        }

        $pourcentage = $scoreMax > 0 ? round(($scoreObtenu / $scoreMax) * 100, 2) : 0.0;

        // 1. Enregistrement en base de données MySQL dans `tentatives_quiz`
        $attemptId = $this->quizModel->saveAttempt(
            (int) $userId,
            $quizId,
            $scoreObtenu,
            $scoreMax,
            $bonnes,
            $mauvaises,
            $pourcentage
        );

        // 2. Mise à jour de la progression dans `progression_lecons` (statut = 'termine')
        $this->lessonModel->markAsCompleted((int) $userId, $leconId);

        // 3. Nettoyage de la session active du quiz
        unset($_SESSION['active_quiz'][$quizId]);

        // Message flash pour la prochaine page
        setFlash('success', "Félicitations ! Vous avez terminé le quiz avec un score de {$scoreObtenu}/{$scoreMax} ({$pourcentage}%).");

        echo json_encode([
            'success'      => true,
            'attempt_id'   => $attemptId,
            'score'        => $scoreObtenu,
            'max_score'    => $scoreMax,
            'pourcentage'  => $pourcentage,
            'redirect_url' => url('/results/' . $attemptId),
        ]);
        exit;
    }

    /**
     * Affiche l'historique complet des tentatives de l'utilisateur.
     * Route : /results
     */
    public function history(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            setFlash('error', "Veuillez vous connecter pour consulter votre historique.");
            redirect('/login');
        }

        $user = $this->userModel->findById((int) $userId);
        if (!$user) {
            session_destroy();
            redirect('/login');
        }

        $dashboardModel = new \App\Models\DashboardModel();
        $history = $dashboardModel->getQuizHistory((int) $userId, 50); // On récupère jusqu'à 50 résultats

        renderView('results/index', [
            'user'    => $user,
            'history' => $history,
        ]);
    }

    /**
     * Affiche la page de bilan de fin de quiz avec les félicitations et les résultats.
     *
     * @param int $attemptId
     */
    public function result(int $attemptId): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            setFlash('error', "Veuillez vous connecter pour consulter vos résultats.");
            redirect('/login');
        }

        $user = $this->userModel->findById((int) $userId);
        if (!$user) {
            session_destroy();
            redirect('/login');
        }

        // Récupération de la tentative réelle depuis MySQL
        $attempt = $this->quizModel->getAttemptDetails($attemptId, (int) $userId);

        if (!$attempt) {
            setFlash('error', "Tentative introuvable ou vous n'êtes pas autorisé à la consulter.");
            redirect('/dashboard');
        }

        renderView('quizzes/result', [
            'user'    => $user,
            'attempt' => $attempt,
        ]);
    }
}

