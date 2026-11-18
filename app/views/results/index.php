<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Résultats — Speech English</title>
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
                <a href="<?= url('/results') ?>" class="nav-link active">📜 Historique</a>
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
        <div class="container mt-4">
            
            <nav class="breadcrumb-nav">
                <a href="<?= url('/dashboard') ?>">Tableau de bord</a> &rsaquo;
                <span class="breadcrumb-current">Historique des évaluations</span>
            </nav>

            <div class="page-intro-header">
                <div>
                    <span class="pill teal">SUIVI DÉTAILLÉ</span>
                    <h1 class="page-title">Votre Historique</h1>
                    <p class="page-subtitle">Retrouvez l'ensemble de vos performances et suivez votre progression sur chaque notion.</p>
                </div>
                <div class="header-actions">
                    <a href="<?= url('/lessons') ?>" class="btn btn-primary">📖 Continuer l'apprentissage</a>
                </div>
            </div>

            <div class="history-card mt-4">
                <?php if (empty($history)): ?>
                    <div class="empty-history-state">
                        <div class="empty-icon">📝</div>
                        <h3>Aucune évaluation enregistrée</h3>
                        <p>Dès que vous terminerez votre premier quiz, vos résultats détaillés s'afficheront ici.</p>
                        <a href="<?= url('/lessons') ?>" class="btn btn-primary mt-3">Voir les leçons</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table-history">
                            <thead>
                                <tr>
                                    <th>Niveau</th>
                                    <th>Quiz & Notion</th>
                                    <th>Score / Points</th>
                                    <th>Réponses</th>
                                    <th>Pourcentage</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($history as $h): ?>
                                    <tr>
                                        <td>
                                            <span class="pill solid-<?= e($h['niveau_code']) ?> sm">
                                                <?= strtoupper(e($h['niveau_code'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong><?= e($h['quiz_titre']) ?></strong>
                                            <div class="table-sub"><?= e($h['lecon_titre']) ?></div>
                                        </td>
                                        <td>
                                            <span class="score-bold"><?= $h['score_obtenu'] ?></span> / <?= $h['score_max'] ?>
                                        </td>
                                        <td>
                                            <span class="text-success" title="Bonnes réponses">✅ <?= $h['bonnes_reponses'] ?></span>
                                            <span class="text-muted mx-1">|</span>
                                            <span class="text-danger" title="Mauvaises réponses">❌ <?= $h['mauvaises_reponses'] ?></span>
                                        </td>
                                        <td>
                                            <?php $pct = round($h['pourcentage']); ?>
                                            <span class="score-badge <?= $pct >= 80 ? 'high' : ($pct >= 50 ? 'mid' : 'low') ?>">
                                                <?= $pct ?>%
                                            </span>
                                        </td>
                                        <td class="table-date">
                                            <?= date('d/m/Y', strtotime($h['date_tentative'])) ?>
                                            <div class="table-sub"><?= date('H:i', strtotime($h['date_tentative'])) ?></div>
                                        </td>
                                        <td>
                                            <a href="<?= url('/results/' . $h['tentative_id']) ?>" class="btn btn-sm btn-ghost" title="Voir le détail">
                                                👁️ Détails
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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
