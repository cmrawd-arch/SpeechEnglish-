<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leçons de Grammaire — Speech English</title>
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
        <div class="container">

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

            <!-- En-tête de section -->
            <div class="page-intro-header">
                <div>
                    <span class="pill teal">CURRICULUM DE GRAMMAIRE</span>
                    <h1 class="page-title">Toutes les leçons par niveau</h1>
                    <p class="page-subtitle">
                        Apprenez les règles essentielles, observez des exemples bilingues commentés et validez vos acquis avec les quiz formateurs.
                    </p>
                </div>
                <div class="header-actions">
                    <a href="<?= url('/dashboard') ?>" class="btn btn-outline">&larr; Retour au tableau de bord</a>
                </div>
            </div>

            <!-- Filtres de niveau -->
            <div class="level-filter-bar">
                <span class="filter-label">Filtrer par niveau :</span>
                <a href="<?= url('/lessons') ?>" class="filter-pill <?= ($currentLevel === 'all') ? 'active' : '' ?>">
                    Tous les niveaux
                </a>
                <a href="<?= url('/levels/easy') ?>" class="filter-pill pill-easy <?= ($currentLevel === 'easy') ? 'active' : '' ?>">
                    🟢 Easy (Débutant)
                </a>
                <a href="<?= url('/levels/basic') ?>" class="filter-pill pill-basic <?= ($currentLevel === 'basic') ? 'active' : '' ?>">
                    🟡 Basic (Intermédiaire)
                </a>
                <a href="<?= url('/levels/hard') ?>" class="filter-pill pill-hard <?= ($currentLevel === 'hard') ? 'active' : '' ?>">
                    🔴 Hard (Avancé)
                </a>
            </div>

            <!-- Contenu des leçons par niveau -->
            <div class="levels-catalog">
                <?php foreach ($levels as $level): ?>
                    <?php 
                        // Si filtre actif et niveau ne correspond pas, on passe
                        if ($currentLevel !== 'all' && strtolower($level['code']) !== $currentLevel) {
                            continue;
                        }
                    ?>
                    <section class="level-catalog-section" id="section-<?= e($level['code']) ?>">
                        <div class="level-catalog-header bg-subtle-<?= e($level['code']) ?>">
                            <div class="level-header-info">
                                <span class="pill solid-<?= e($level['code']) ?>">
                                    Niveau <?= strtoupper(e($level['code'])) ?>
                                </span>
                                <h2 class="level-catalog-title"><?= e($level['titre']) ?></h2>
                                <p class="level-catalog-desc"><?= e($level['description']) ?></p>
                            </div>
                            <div class="level-badge-count">
                                <strong><?= count($level['lessons']) ?></strong>
                                <span>leçon(s)</span>
                            </div>
                        </div>

                        <div class="lesson-cards-grid">
                            <?php if (empty($level['lessons'])): ?>
                                <p class="text-muted p-4">Aucune leçon disponible dans ce niveau pour le moment.</p>
                            <?php else: ?>
                                <?php foreach ($level['lessons'] as $idx => $les): ?>
                                    <div class="lesson-card">
                                        <div class="lesson-card-header">
                                            <span class="lesson-number">Leçon <?= $idx + 1 ?></span>
                                            
                                            <?php if ($les['user_statut'] === 'termine'): ?>
                                                <span class="badge-status badge-done">✓ Terminée</span>
                                            <?php elseif ($les['user_statut'] === 'en_cours'): ?>
                                                <span class="badge-status badge-in-progress">⏳ En cours</span>
                                            <?php else: ?>
                                                <span class="badge-status badge-new">Nouveau</span>
                                            <?php endif; ?>
                                        </div>

                                        <h3 class="lesson-card-title">
                                            <a href="<?= url('/lessons/' . $les['id']) ?>">
                                                <?= e($les['titre']) ?>
                                            </a>
                                        </h3>

                                        <div class="lesson-card-meta">
                                            <?php if ($les['user_last_score'] !== null): ?>
                                                <div class="last-score-indicator">
                                                    Dernier score : <strong><?= round($les['user_last_score']) ?>%</strong>
                                                </div>
                                            <?php else: ?>
                                                <div class="last-score-indicator muted">
                                                    Quiz non encore réalisé
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="lesson-card-actions">
                                            <a href="<?= url('/lessons/' . $les['id']) ?>" class="btn btn-sm btn-primary">
                                                📖 Consulter la leçon
                                            </a>
                                            <?php if (!empty($les['quiz_id'])): ?>
                                                <a href="<?= url('/quiz/' . $les['quiz_id']) ?>" class="btn btn-sm btn-secondary" title="<?= e($les['quiz_titre']) ?>">
                                                    ✏️ Quiz associé &rarr;
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>

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

