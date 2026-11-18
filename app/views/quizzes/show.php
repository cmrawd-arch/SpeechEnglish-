<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($quiz['titre']) ?> — Speech English</title>
    <link rel="stylesheet" href="<?= url('/assets/css/style.css') ?>">
</head>
<body class="dashboard-body quiz-page">

    <!-- En-tête / Barre de navigation -->
    <header class="app-header">
        <div class="header-container">
            <div class="brand">
                <a href="<?= url('/dashboard') ?>" class="brand-link">
                    <span class="brand-flag">🇬🇧</span>
                    <span class="brand-name">Speech<strong>English</strong></span>
                </a>
            </div>

            <nav class="nav-links">
                <a href="<?= url('/dashboard') ?>" class="nav-link">📊 Tableau de bord</a>
                <a href="<?= url('/lessons') ?>" class="nav-link">📖 Catalogue des leçons</a>
                <a href="<?= url('/lessons/' . $quiz['lecon_id']) ?>" class="nav-link">&larr; Revoir la leçon</a>
            </nav>

            <div class="header-user">
                <div class="user-avatar-badge">
                    <?= strtoupper(substr($user['prenom'], 0, 1) . substr($user['nom'], 0, 1)) ?>
                </div>
                <div class="user-meta">
                    <span class="user-greeting"><?= e($user['prenom']) ?> <?= e($user['nom']) ?></span>
                </div>
                <a href="<?= url('/logout') ?>" class="btn-logout" title="Déconnexion">Déconnexion</a>
            </div>
        </div>
    </header>

    <main class="dashboard-main">
        <div class="container quiz-container">

            <!-- Fil d'Ariane -->
            <nav class="breadcrumb-nav">
                <a href="<?= url('/dashboard') ?>">Tableau de bord</a> &rsaquo;
                <a href="<?= url('/lessons') ?>">Leçons</a> &rsaquo;
                <a href="<?= url('/lessons/' . $quiz['lecon_id']) ?>"><?= e($quiz['lecon_titre']) ?></a> &rsaquo;
                <span class="breadcrumb-current"><?= e($quiz['titre']) ?></span>
            </nav>

            <!-- Boîte de quiz principale -->
            <div class="quiz-card-wrapper border-top-<?= e($quiz['niveau_code']) ?>">
                
                <!-- En-tête du quiz -->
                <div class="quiz-interface-header">
                    <div class="quiz-header-title-row">
                        <div>
                            <span class="pill solid-<?= e($quiz['niveau_code']) ?>">
                                NIVEAU <?= strtoupper(e($quiz['niveau_code'])) ?> &middot; <?= e($quiz['niveau_titre']) ?>
                            </span>
                            <h1 class="quiz-title"><?= e($quiz['titre']) ?></h1>
                            <p class="quiz-subtitle">
                                <?= e($quiz['description'] ?: 'Répondez attentivement à chaque question. Une correction immédiate avec justification vous sera fournie.') ?>
                            </p>
                        </div>
                        <div class="quiz-score-badge">
                            <span class="score-caption">Score actuel</span>
                            <div class="score-numbers">
                                <span id="current-score-val">0</span>
                                <span class="score-divider">/</span>
                                <span id="max-score-val"><?= count($questions) ?></span>
                            </div>
                            <?php if ($bestScore): ?>
                                <small class="text-muted">Meilleur : <?= round($bestScore['pourcentage']) ?>%</small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Barre de progression de la question -->
                    <div class="quiz-progress-container">
                        <div class="progress-info-row">
                            <span class="progress-step-text">
                                Question <strong id="step-current">1</strong> sur <strong><?= count($questions) ?></strong>
                            </span>
                            <span class="progress-pct-text" id="step-pct">
                                <?= round((1 / count($questions)) * 100) ?>%
                            </span>
                        </div>
                        <div class="quiz-track">
                            <div class="quiz-fill bg-<?= e($quiz['niveau_code']) ?>" id="quiz-progress-bar" style="width: <?= round((1 / count($questions)) * 100) ?>%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Conteneur des questions (Une seule question visible à la fois) -->
                <div class="questions-deck" id="questions-deck" 
                     data-quiz-id="<?= $quiz['id'] ?>"
                     data-validate-url="<?= url('/quiz/' . $quiz['id'] . '/validate') ?>"
                     data-finish-url="<?= url('/quiz/' . $quiz['id'] . '/finish') ?>"
                     data-total-questions="<?= count($questions) ?>">

                    <?php 
                    $letters = ['A', 'B', 'C', 'D', 'E'];
                    foreach ($questions as $index => $q): 
                    ?>
                        <div class="question-step <?= $index === 0 ? 'active' : '' ?>" 
                             id="question-step-<?= $q['id'] ?>" 
                             data-question-id="<?= $q['id'] ?>" 
                             data-index="<?= $index + 1 ?>">

                            <!-- Énoncé de la question -->
                            <div class="question-header">
                                <span class="question-badge">Question <?= $index + 1 ?></span>
                                <span class="question-points">1 point</span>
                            </div>

                            <div class="question-enonce">
                                <p><?= e($q['enonce']) ?></p>
                            </div>

                            <!-- Choix de réponses (QCM) -->
                            <div class="propositions-list" id="propositions-<?= $q['id'] ?>">
                                <?php foreach ($q['propositions'] as $pIdx => $prop): ?>
                                    <label class="proposal-card" id="prop-card-<?= $prop['id'] ?>" for="radio-<?= $prop['id'] ?>">
                                        <input type="radio" 
                                               name="question_choice_<?= $q['id'] ?>" 
                                               id="radio-<?= $prop['id'] ?>" 
                                               value="<?= $prop['id'] ?>" 
                                               class="proposal-radio">
                                        <span class="proposal-bullet"><?= $letters[$pIdx % 5] ?></span>
                                        <span class="proposal-label-text"><?= e($prop['texte_reponse']) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <!-- Message d'erreur local (si validation sans sélection) -->
                            <div class="validation-error-msg" id="error-msg-<?= $q['id'] ?>" hidden>
                                ⚠️ Veuillez sélectionner une réponse avant de valider.
                            </div>

                            <!-- Bloc d'action initial : Validation -->
                            <div class="question-action-bar" id="action-validate-<?= $q['id'] ?>">
                                <button type="button" 
                                        class="btn btn-primary btn-validate" 
                                        data-qid="<?= $q['id'] ?>" 
                                        disabled>
                                    ✓ Valider ma réponse
                                </button>
                                <span class="hint-text">Sélectionnez une option pour débloquer la validation.</span>
                            </div>

                            <!-- Zone de feedback pédagogique (Révélée UNIQUEMENT après validation serveur) -->
                            <div class="feedback-reveal-zone" id="feedback-zone-<?= $q['id'] ?>" hidden>
                                
                                <!-- Bannière Bonne réponse / Mauvaise réponse -->
                                <div class="feedback-banner" id="banner-<?= $q['id'] ?>">
                                    <div class="feedback-icon" id="icon-<?= $q['id'] ?>"></div>
                                    <div class="feedback-content">
                                        <h4 class="feedback-status-title" id="status-title-<?= $q['id'] ?>"></h4>
                                        <p class="feedback-status-desc" id="status-desc-<?= $q['id'] ?>"></p>
                                    </div>
                                </div>

                                <!-- Boîte d'explication pédagogique issue de MySQL -->
                                <div class="pedagogical-explanation-box">
                                    <div class="explanation-header">
                                        <span class="explanation-icon">💡</span>
                                        <strong>Explication pédagogique :</strong>
                                    </div>
                                    <div class="explanation-body" id="explanation-text-<?= $q['id'] ?>">
                                        <!-- Rempli dynamiquement par la réponse serveur -->
                                    </div>
                                </div>

                                <!-- Bouton pour passer à l'étape suivante -->
                                <div class="next-step-bar">
                                    <?php if ($index + 1 < count($questions)): ?>
                                        <button type="button" 
                                                class="btn btn-secondary btn-next-step" 
                                                data-current-qid="<?= $q['id'] ?>" 
                                                data-next-index="<?= $index + 2 ?>">
                                            Question suivante &rarr;
                                        </button>
                                    <?php else: ?>
                                        <button type="button" 
                                                class="btn btn-success btn-finish-quiz" 
                                                id="btn-finish-quiz" 
                                                data-quiz-id="<?= $quiz['id'] ?>">
                                            🎯 Terminer le quiz & voir mon bilan &rarr;
                                        </button>
                                    <?php endif; ?>
                                </div>

                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>

            </div>

        </div>
    </main>

    <footer class="app-footer">
        <div class="container text-center">
            <p>Speech English &copy; <?= date('Y') ?> — TD Fondamentaux du Web &middot; MIAGE 2ème année</p>
        </div>
    </footer>

    <script src="<?= url('/assets/js/quiz.js') ?>"></script>
</body>
</html>

