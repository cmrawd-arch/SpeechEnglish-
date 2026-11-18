<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($lesson['titre']) ?> — Speech English</title>
    <link rel="stylesheet" href="<?= url('/assets/css/style.css') ?>">
</head>
<body class="dashboard-body">

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
                <a href="<?= url('/lessons') ?>" class="nav-link active">📖 Catalogue des leçons</a>
                <a href="<?= url('/dashboard#quiz-section') ?>" class="nav-link">✏️ Quiz</a>
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
        <div class="container lesson-container">

            <!-- Fil d'Ariane / Breadcrumb -->
            <nav class="breadcrumb-nav">
                <a href="<?= url('/dashboard') ?>">Tableau de bord</a> &rsaquo;
                <a href="<?= url('/lessons') ?>">Leçons</a> &rsaquo;
                <a href="<?= url('/levels/' . e($lesson['niveau_code'])) ?>" class="breadcrumb-level">
                    Niveau <?= strtoupper(e($lesson['niveau_code'])) ?>
                </a> &rsaquo;
                <span class="breadcrumb-current"><?= e($lesson['titre']) ?></span>
            </nav>

            <!-- Messages flash -->
            <?php if (hasFlash('success')): ?>
                <div class="alert alert-success">
                    ✓ <?= e(getFlash('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (hasFlash('error')): ?>
                <div class="alert alert-error">
                    ✕ <?= e(getFlash('error')) ?>
                </div>
            <?php endif; ?>

            <!-- En-tête de la leçon -->
            <article class="lesson-article">
                <header class="lesson-header border-top-<?= e($lesson['niveau_code']) ?>">
                    <div class="lesson-badges">
                        <span class="pill solid-<?= e($lesson['niveau_code']) ?>">
                            <?= strtoupper(e($lesson['niveau_code'])) ?> &middot; <?= e($lesson['niveau_titre']) ?>
                        </span>
                        
                        <?php if ($lesson['user_statut'] === 'termine'): ?>
                            <span class="badge-status badge-done">✓ Leçon terminée</span>
                        <?php else: ?>
                            <span class="badge-status badge-in-progress">⏳ Leçon en cours d'apprentissage</span>
                        <?php endif; ?>

                        <?php if (!empty($lesson['user_last_score'])): ?>
                            <span class="score-pill">
                                Dernier score au quiz : <strong><?= round($lesson['user_last_score']['pourcentage']) ?>%</strong>
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 class="lesson-main-title"><?= e($lesson['titre']) ?></h1>

                    <div class="lesson-meta-bar">
                        <span class="lesson-meta-item">⏱️ Durée estimée : ~10 minutes</span>
                        <span class="lesson-meta-item">🎯 Objectif : Maîtrise grammaticale & réflexes</span>
                        <?php if (!empty($lesson['quiz_id'])): ?>
                            <a href="<?= url('/quiz/' . $lesson['quiz_id']) ?>" class="btn-quiz-jump">
                                ✏️ Accéder directement au quiz &rarr;
                            </a>
                        <?php endif; ?>
                    </div>
                </header>

                <!-- Contenu pédagogique structuré issu de MySQL -->
                <div class="lesson-body">
                    <?= $lesson['contenu'] ?>
                </div>

                <!-- Bloc d'action / Lancement du Quiz associé (Exigence obligatoire) -->
                <?php if (!empty($lesson['quiz_id'])): ?>
                    <div class="lesson-quiz-cta-card">
                        <div class="cta-icon-box">✏️</div>
                        <div class="cta-content">
                            <span class="pill gold sm">VALIDATION DES ACQUIS</span>
                            <h3>Prêt(e) à tester votre compréhension ?</h3>
                            <p>
                                Répondez aux questions du <strong><?= e($lesson['quiz_titre']) ?></strong>.
                                Correction instantanée, explications détaillées et enregistrement de votre score dans votre progression.
                            </p>
                        </div>
                        <div class="cta-action">
                            <a href="<?= url('/quiz/' . $lesson['quiz_id']) ?>" class="btn btn-primary btn-lg btn-pulse">
                                Commencer le quiz associé &rarr;
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Barre de navigation entre leçons -->
                <footer class="lesson-footer-nav">
                    <div class="nav-prev">
                        <?php if (!empty($lesson['previous_lesson'])): ?>
                            <a href="<?= url('/lessons/' . $lesson['previous_lesson']['id']) ?>" class="btn-nav-lesson">
                                &larr; Leçon précédente : <?= e($lesson['previous_lesson']['titre']) ?>
                            </a>
                        <?php else: ?>
                            <span class="btn-nav-disabled">&larr; Première leçon du niveau</span>
                        <?php endif; ?>
                    </div>

                    <div class="nav-catalog">
                        <a href="<?= url('/lessons') ?>" class="btn btn-outline btn-sm">
                            📋 Toutes les leçons
                        </a>
                    </div>

                    <div class="nav-next">
                        <?php if (!empty($lesson['next_lesson'])): ?>
                            <a href="<?= url('/lessons/' . $lesson['next_lesson']['id']) ?>" class="btn-nav-lesson">
                                Leçon suivante : <?= e($lesson['next_lesson']['titre']) ?> &rarr;
                            </a>
                        <?php else: ?>
                            <span class="btn-nav-disabled">Dernière leçon du niveau &rarr;</span>
                        <?php endif; ?>
                    </div>
                </footer>
            </article>

        </div>
    </main>

    <footer class="app-footer">
        <div class="container text-center">
            <p>Speech English &copy; <?= date('Y') ?> — TD Fondamentaux du Web &middot; MIAGE 2ème année</p>
        </div>
    </footer>

    <script src="<?= url('/assets/js/main.js') ?>"></script>
</body>
</html>

