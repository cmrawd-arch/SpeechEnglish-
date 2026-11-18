<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat du Quiz — Speech English</title>
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
                <a href="<?= url('/lessons') ?>" class="nav-link">📖 Catalogue des leçons</a>
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
        <div class="container quiz-container">

            <!-- Message flash éventuel -->
            <?php if (hasFlash('success')): ?>
                <div class="alert alert-success">
                    ✓ <?= e(getFlash('success')) ?>
                </div>
            <?php endif; ?>

            <!-- Carte de résultat centralisée -->
            <div class="result-card-wrap border-top-<?= e($attempt['niveau_code']) ?>">
                
                <div class="result-celebration-badge">
                    <?php if ($attempt['pourcentage'] >= 80): ?>
                        <span class="badge-icon-huge">🏆</span>
                    <?php elseif ($attempt['pourcentage'] >= 50): ?>
                        <span class="badge-icon-huge">⭐</span>
                    <?php else: ?>
                        <span class="badge-icon-huge">📖</span>
                    <?php endif; ?>
                </div>

                <div class="result-level-chip">
                    <span class="pill solid-<?= e($attempt['niveau_code']) ?>">
                        NIVEAU <?= strtoupper(e($attempt['niveau_code'])) ?> &middot; <?= e($attempt['niveau_titre']) ?>
                    </span>
                </div>

                <h1 class="result-title">Bilan du <?= e($attempt['quiz_titre']) ?></h1>
                <p class="result-lesson-ref">Lié à la leçon : <strong><?= e($attempt['lecon_titre']) ?></strong></p>

                <!-- Cadre Score -->
                <div class="result-score-box">
                    <div class="score-circle">
                        <span class="circle-number"><?= round($attempt['pourcentage']) ?>%</span>
                        <span class="circle-label"><?= $attempt['score_obtenu'] ?> / <?= $attempt['score_max'] ?> point(s)</span>
                    </div>

                    <div class="result-feedback-message">
                        <?php if ($attempt['pourcentage'] == 100): ?>
                            <h3 class="feedback-heading success">Score parfait ! Félicitations !</h3>
                            <p class="feedback-text">
                                Vous maîtrisez parfaitement cette notion de grammaire. Votre progression a été enregistrée avec succès.
                            </p>
                        <?php elseif ($attempt['pourcentage'] >= 70): ?>
                            <h3 class="feedback-heading success">Très bon travail !</h3>
                            <p class="feedback-text">
                                La règle est bien acquise. Vous pouvez passer à la notion suivante en toute confiance ou relire les détails pour consolider.
                            </p>
                        <?php elseif ($attempt['pourcentage'] >= 40): ?>
                            <h3 class="feedback-heading warning">Bon début, mais des confusions persistent.</h3>
                            <p class="feedback-text">
                                Prenez quelques minutes pour relire la fiche explicative et les exemples bilingues, puis retentez le quiz.
                            </p>
                        <?php else: ?>
                            <h3 class="feedback-heading error">La notion nécessite d'être revue.</h3>
                            <p class="feedback-text">
                                Ne vous découragez pas ! La grammaire anglaise s'acquiert avec de la pratique. Nous vous recommandons de relire attentivement la leçon.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Métadonnées d'enregistrement -->
                <div class="result-meta-footer">
                    <span>🗓️ Évaluation enregistrée en base de données le <?= date('d/m/Y à H:i', strtotime($attempt['date_tentative'])) ?></span>
                    <span>✓ Statut de la leçon mis à jour : <strong>Terminée</strong></span>
                </div>

                <!-- Boutons d'action -->
                <div class="result-actions-deck">
                    <a href="<?= url('/quiz/' . $attempt['quiz_id']) ?>" class="btn btn-outline">
                        🔄 Recommencer le quiz
                    </a>
                    <a href="<?= url('/lessons/' . $attempt['lecon_id']) ?>" class="btn btn-secondary">
                        📖 Revoir la leçon
                    </a>
                    <a href="<?= url('/dashboard') ?>" class="btn btn-primary">
                        📊 Mon tableau de bord &rarr;
                    </a>
                </div>

            </div>

        </div>
    </main>

    <footer class="app-footer">
        <div class="container text-center">
            <p>Speech English &copy; <?= date('Y') ?> — TD Fondamentaux du Web &middot; MIAGE 2ème année</p>
        </div>
    </footer>

</body>
</html>

