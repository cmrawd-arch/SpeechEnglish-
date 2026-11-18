<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord — Speech English</title>
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body class="dashboard-body">

    <!-- ======================================================================= -->
    <!-- BARRE SUPÉRIEURE (Identique à la présentation-lv1)                       -->
    <!-- ======================================================================= -->
    <header class="topbar">
        <div class="brand">
            <div class="logo-mini">SE</div>
            <strong>Speech English</strong>
            <span class="brand-sep">·</span>
            <span class="brand-subtitle">Tableau de bord apprenant</span>
        </div>

        <nav class="top-nav">
            <a href="<?= url('/dashboard') ?>" class="nav-item active">
                <span class="nav-icon">📊</span> Tableau de bord
            </a>
            <a href="<?= url('/lessons') ?>" class="nav-item">
                <span class="nav-icon">📚</span> Leçons par niveau
            </a>
            <a href="<?= url('/results') ?>" class="nav-item">
                <span class="nav-icon">📜</span> Historique
            </a>
            <a href="#quiz-section" class="nav-item">
                <span class="nav-icon">✏️</span> Quiz
            </a>
            <a href="#historique-section" class="nav-item">
                <span class="nav-icon">📜</span> Historique
            </a>
        </nav>

        <div class="user-profile-menu">
            <div class="user-avatar" title="<?= e($user['prenom'] . ' ' . $user['nom']) ?>">
                <?= strtoupper(substr(e($user['prenom']), 0, 1) . substr(e($user['nom']), 0, 1)) ?>
            </div>
            <span class="user-display-name"><?= e($user['prenom'] . ' ' . $user['nom']) ?></span>
            <a href="<?= url('logout') ?>" class="btn-logout" title="Se déconnecter">
                Déconnexion ⎋
            </a>
        </div>
    </header>

    <div class="dashboard-container">

        <!-- =================================================================== -->
        <!-- BANNIÈRE DE BIENVENUE                                               -->
        <!-- =================================================================== -->
        <section class="welcome-hero">
            <div class="welcome-text">
                <span class="pill red">ESPACE PERSONNEL</span>
                <h1 class="welcome-title">
                    Bienvenue, <span class="highlight"><?= e($user['prenom']) ?> <?= e($user['nom']) ?></span> !
                </h1>
                <p class="welcome-subtitle">
                    Prêt à consolider votre grammaire anglaise ? Suivez votre progression réelle, révisez vos leçons et relevez les quiz par niveau.
                </p>
            </div>
            <div class="welcome-actions">
                <a href="#niveaux" class="btn btn-primary btn-lg">Accéder aux leçons</a>
                <a href="#quiz-section" class="btn btn-outline btn-lg">Lancer un quiz</a>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- SECTION 1 : LES 3 INDICATEURS CLÉS RÉELS (Données 100% MySQL)       -->
        <!-- =================================================================== -->
        <section class="kpi-grid">
            
            <!-- KPI 1 : Progression globale réelle -->
            <div class="kpi-card">
                <div class="kpi-header">
                    <span class="kpi-label">Progression globale</span>
                    <span class="kpi-icon teal">📈</span>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-number" id="kpi-progress"><?= $stats['progression_percent'] ?>%</span>
                    <span class="kpi-badge"><?= $stats['quizzes_completed'] ?> / <?= $stats['total_quizzes_app'] ?> quiz</span>
                </div>
                <!-- Jauge animée -->
                <div class="progress-track">
                    <div class="progress-bar bg-teal" style="width: <?= $stats['progression_percent'] ?>%;"></div>
                </div>
                <p class="kpi-detail">
                    <?= $stats['lessons_completed'] ?> leçon(s) terminée(s) sur <?= $stats['total_lessons_app'] ?> disponibles.
                </p>
            </div>

            <!-- KPI 2 : Nombre de quiz réalisés -->
            <div class="kpi-card">
                <div class="kpi-header">
                    <span class="kpi-label">Quiz réalisés</span>
                    <span class="kpi-icon gold">✏️</span>
                </div>
                <div class="kpi-value-row">
                    <span class="kpi-number"><?= $stats['total_attempts'] ?></span>
                    <span class="kpi-unit">tentative(s)</span>
                </div>
                <div class="kpi-meta">
                    <?php if ($stats['average_score'] !== null): ?>
                        <span class="kpi-subtext">Score moyen : <strong><?= $stats['average_score'] ?>%</strong></span>
                    <?php else: ?>
                        <span class="kpi-subtext">Aucune note enregistrée</span>
                    <?php endif; ?>
                </div>
                <p class="kpi-detail">
                    <?= $stats['quizzes_completed'] ?> quiz distinct(s) déjà accompli(s).
                </p>
            </div>

            <!-- KPI 3 : Dernier score réel -->
            <div class="kpi-card">
                <div class="kpi-header">
                    <span class="kpi-label">Dernier score</span>
                    <span class="kpi-icon red">🎯</span>
                </div>

                <?php if ($latestScore): ?>
                    <div class="kpi-value-row">
                        <span class="kpi-number"><?= $latestScore['score_obtenu'] ?> / <?= $latestScore['score_max'] ?></span>
                        <span class="pill solid-<?= e($latestScore['niveau_code']) ?> kpi-pill">
                            <?= round($latestScore['pourcentage']) ?>%
                        </span>
                    </div>
                    <div class="latest-quiz-info">
                        <strong><?= e($latestScore['quiz_titre']) ?></strong>
                        <span class="latest-date">
                            Le <?= date('d/m/Y à H:i', strtotime($latestScore['date_tentative'])) ?>
                        </span>
                    </div>
                <?php else: ?>
                    <div class="kpi-empty">
                        <span class="kpi-number muted">—</span>
                        <p class="kpi-detail mt-1">Vous n'avez pas encore passé de quiz.</p>
                        <a href="#quiz-section" class="btn btn-sm btn-outline mt-2">Démarrer le 1er quiz</a>
                    </div>
                <?php endif; ?>
            </div>

        </section>

        <!-- =================================================================== -->
        <!-- SECTION 2 : LES TROIS NIVEAUX (EASY · BASIC · HARD)                  -->
        <!-- =================================================================== -->
        <section id="niveaux" class="dashboard-section">
            <div class="section-title-wrap">
                <div>
                    <span class="pill red">PARCOURS D'APPRENTISSAGE</span>
                    <h2 class="section-title">Les trois niveaux de grammaire</h2>
                </div>
                <p class="section-desc">
                    Sélectionnez un niveau pour accéder aux fiches de cours et lancer les quiz d'évaluation correspondants.
                </p>
            </div>

            <div class="levels-deck">
                <?php foreach ($levels as $index => $lvl): ?>
                    <div class="level-card <?= e($lvl['code']) ?>" id="card-<?= e($lvl['code']) ?>">
                        <span class="bignum"><?= $index + 1 ?></span>
                        
                        <div class="level-top">
                            <span class="pill solid-<?= e($lvl['code']) ?>">
                                <?= strtoupper(e($lvl['code'])) ?> LEVEL
                            </span>
                            <span class="school">
                                <?php 
                                    if ($lvl['code'] === 'easy') echo 'Primary';
                                    elseif ($lvl['code'] === 'basic') echo 'College';
                                    else echo 'High school';
                                ?>
                            </span>
                        </div>

                        <h3><?= e($lvl['titre']) ?></h3>
                        <p class="level-desc"><?= e($lvl['description']) ?></p>

                        <!-- Progression réelle du niveau -->
                        <div class="level-progress-box">
                            <div class="level-progress-label">
                                <span>Progression du niveau</span>
                                <strong><?= $lvl['progress_percent'] ?>%</strong>
                            </div>
                            <div class="track">
                                <span class="bg-<?= e($lvl['code']) ?>" style="width: <?= $lvl['progress_percent'] ?>%;"></span>
                            </div>
                            <small><?= $lvl['completed_lessons'] ?> / <?= $lvl['total_lessons'] ?> notion(s) maîtrisée(s)</small>
                        </div>

                        <!-- Boutons d'accès aux leçons et quiz de ce niveau -->
                        <div class="level-actions">
                            <button class="btn btn-level-toggle" data-target="lessons-<?= e($lvl['code']) ?>">
                                📖 Voir les leçons (<?= count($lvl['lessons']) ?>)
                            </button>
                            <a href="#quiz-section" class="btn btn-level-quiz">
                                ✏️ Quiz associés
                            </a>
                        </div>

                        <!-- Liste déroulante des leçons du niveau -->
                        <div class="level-lessons-drawer" id="lessons-<?= e($lvl['code']) ?>" hidden>
                            <ul class="lessons-list">
                                <?php foreach ($lvl['lessons'] as $les): ?>
                                    <li class="lesson-item">
                                        <div class="lesson-title-meta">
                                            <span class="lesson-bullet">•</span>
                                            <a href="<?= url('/lessons/' . $les['lecon_id']) ?>" class="lesson-name" style="text-decoration:none;color:#14213d;font-weight:600;">
                                                <?= e($les['lecon_titre']) ?>
                                            </a>
                                        </div>
                                        <div class="lesson-item-actions">
                                            <?php if ($les['user_last_score'] !== null): ?>
                                                <span class="score-chip">Score : <?= round($les['user_last_score']) ?>%</span>
                                            <?php else: ?>
                                                <span class="score-chip neutral">À faire</span>
                                            <?php endif; ?>
                                            <a href="<?= url('/lessons/' . $les['lecon_id']) ?>" class="btn-xs-link" style="margin-left:0.5rem;font-size:0.8rem;color:#2a9d8f;font-weight:600;">
                                                Lire &rarr;
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- SECTION 3 : ACCÈS AUX QUIZ D'ENTRAÎNEMENT                          -->
        <!-- =================================================================== -->
        <section id="quiz-section" class="dashboard-section mt-5">
            <div class="section-title-wrap">
                <div>
                    <span class="pill gold">ÉVALUATION FORMATIVE</span>
                    <h2 class="section-title">Accès rapide aux quiz</h2>
                </div>
                <p class="section-desc">
                    Testez vos compétences avec correction instantanée et enregistrement immédiat de votre score en base de données.
                </p>
            </div>

            <div class="quiz-grid">
                <?php foreach ($levels as $lvl): ?>
                    <?php foreach ($lvl['lessons'] as $les): ?>
                        <?php if (!empty($les['quiz_id'])): ?>
                            <div class="quiz-card border-<?= e($lvl['code']) ?>">
                                <div class="quiz-card-top">
                                    <span class="pill solid-<?= e($lvl['code']) ?> sm">
                                        <?= strtoupper(e($lvl['code'])) ?>
                                    </span>
                                    <?php if ($les['user_last_score'] !== null): ?>
                                        <span class="badge-done">✓ Validé (<?= round($les['user_last_score']) ?>%)</span>
                                    <?php else: ?>
                                        <span class="badge-todo">Non effectué</span>
                                    <?php endif; ?>
                                </div>
                                <h4><?= e($les['quiz_titre'] ?: 'Quiz : ' . $les['lecon_titre']) ?></h4>
                                <p class="quiz-lesson-ref">Lié à : <?= e($les['lecon_titre']) ?></p>
                                
                                <div class="quiz-card-footer">
                                    <a href="<?= url('/quiz/' . $les['quiz_id']) ?>" class="btn btn-primary btn-sm btn-block">
                                        <?= $les['user_last_score'] !== null ? 'Recommencer le quiz' : 'Démarrer le quiz' ?> &rarr;
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- =================================================================== -->
        <!-- SECTION 4 : HISTORIQUE RÉEL DES SCORES (MySQL)                      -->
        <!-- =================================================================== -->
        <section id="historique-section" class="dashboard-section mt-5">
            <div class="section-title-wrap">
                <div>
                    <span class="pill teal">SUIVI ANALYTIQUE</span>
                    <h2 class="section-title">Historique de vos tentatives</h2>
                </div>
                <div>
                    <a href="<?= url('/results') ?>" class="btn btn-outline btn-sm">Voir tout l'historique &rarr;</a>
                </div>
            </div>

            <div class="history-card">
                <?php if (empty($history)): ?>
                    <div class="empty-history-state">
                        <div class="empty-icon">📝</div>
                        <h3>Aucun historique pour le moment</h3>
                        <p>Dès que vous terminerez votre premier quiz, vos scores et vos dates de passage s'afficheront ici.</p>
                        <a href="#quiz-section" class="btn btn-primary mt-3">Passer mon premier quiz</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table-history">
                            <thead>
                                <tr>
                                    <th>Niveau</th>
                                    <th>Quiz & Notion évaluée</th>
                                    <th>Score obtenu</th>
                                    <th>Pourcentage</th>
                                    <th>Date de réalisation</th>
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
                                            <?php $pct = round($h['pourcentage']); ?>
                                            <span class="score-badge <?= $pct >= 80 ? 'high' : ($pct >= 50 ? 'mid' : 'low') ?>">
                                                <?= $pct ?>%
                                            </span>
                                        </td>
                                        <td class="table-date">
                                            <?= date('d/m/Y à H:i', strtotime($h['date_tentative'])) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </div>

    <!-- ======================================================================= -->
    <!-- PIED DE PAGE                                                           -->
    <!-- ======================================================================= -->
    <footer class="dashboard-footer">
        <p>&copy; <?= date('Y') ?> <strong>Speech English</strong> — Projet MIAGE 2 · Fondamentaux du Web.</p>
        <p class="footer-note">Données utilisateur réelles connectées à MySQL (XAMPP).</p>
    </footer>

    <script src="<?= url('assets/js/main.js') ?>"></script>
</body>
</html>

