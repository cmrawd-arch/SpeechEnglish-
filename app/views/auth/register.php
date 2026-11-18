<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Speech English</title>
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body class="auth-body">

    <div class="auth-wrapper">
        <!-- Logo & Titre de marque -->
        <header class="auth-header">
            <div class="brand-logo">
                <span class="logo-circle">SE</span>
                <span class="brand-title">Speech English</span>
            </div>
            <p class="brand-tagline">Apprenez la grammaire anglaise, étape par étape.</p>
        </header>

        <!-- Carte principale d'inscription -->
        <main class="auth-card">

            <?php if (!empty($success)): ?>
                <!-- ============================================================ -->
                <!-- ÉCRAN DE SUCCÈS : Inscription réussie et invitation de login -->
                <!-- ============================================================ -->
                <div class="success-banner" role="alert">
                    <div class="success-icon">✓</div>
                    <h2>Inscription Réussie !</h2>
                    <p class="success-message"><?= e($success) ?></p>

                    <div class="success-actions">
                        <a href="<?= url('login') ?>" class="btn btn-primary btn-block btn-lg">
                            Se connecter maintenant &rarr;
                        </a>
                        <a href="<?= url('register') ?>" class="btn btn-ghost btn-sm">
                            Créer un autre compte
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <!-- ============================================================ -->
                <!-- FORMULAIRE D'INSCRIPTION                                      -->
                <!-- ============================================================ -->
                <div class="form-title-group">
                    <h1>Créer un compte</h1>
                    <p class="form-subtitle">Remplissez le formulaire ci-dessous pour démarrer vos entraînements.</p>
                </div>

                <!-- Alerte d'erreur générale le cas échéant -->
                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Erreur :</strong> <?= e($errors['general']) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= url('register') ?>" method="POST" id="register-form" novalidate autocomplete="on">
                    
                    <!-- Ligne : Nom & Prénom -->
                    <div class="form-row">
                        <div class="form-group <?= !empty($errors['nom']) ? 'has-error' : '' ?>">
                            <label for="nom">Nom <span class="required">*</span></label>
                            <input 
                                type="text" 
                                id="nom" 
                                name="nom" 
                                class="form-control" 
                                placeholder="Ex. Dupont" 
                                value="<?= e(old('nom')) ?>" 
                                required 
                                minlength="2"
                                autocomplete="family-name"
                            >
                            <span class="error-feedback" id="nom-error">
                                <?= !empty($errors['nom']) ? e($errors['nom']) : '' ?>
                            </span>
                        </div>

                        <div class="form-group <?= !empty($errors['prenom']) ? 'has-error' : '' ?>">
                            <label for="prenom">Prénom <span class="required">*</span></label>
                            <input 
                                type="text" 
                                id="prenom" 
                                name="prenom" 
                                class="form-control" 
                                placeholder="Ex. Thomas" 
                                value="<?= e(old('prenom')) ?>" 
                                required 
                                minlength="2"
                                autocomplete="given-name"
                            >
                            <span class="error-feedback" id="prenom-error">
                                <?= !empty($errors['prenom']) ? e($errors['prenom']) : '' ?>
                            </span>
                        </div>
                    </div>

                    <!-- Champ : Adresse email -->
                    <div class="form-group <?= !empty($errors['email']) ? 'has-error' : '' ?>">
                        <label for="email">Adresse email <span class="required">*</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control" 
                            placeholder="nom@exemple.com" 
                            value="<?= e(old('email')) ?>" 
                            required 
                            autocomplete="email"
                        >
                        <span class="error-feedback" id="email-error">
                            <?= !empty($errors['email']) ? e($errors['email']) : '' ?>
                        </span>
                    </div>

                    <!-- Champ : Mot de passe -->
                    <div class="form-group <?= !empty($errors['mot_de_passe']) ? 'has-error' : '' ?>">
                        <label for="mot_de_passe">Mot de passe <span class="required">*</span></label>
                        <input 
                            type="password" 
                            id="mot_de_passe" 
                            name="mot_de_passe" 
                            class="form-control" 
                            placeholder="6 caractères minimum" 
                            required 
                            minlength="6"
                            autocomplete="new-password"
                        >
                        <small class="form-hint">Doit contenir au moins 6 caractères.</small>
                        <span class="error-feedback" id="mot-de-passe-error">
                            <?= !empty($errors['mot_de_passe']) ? e($errors['mot_de_passe']) : '' ?>
                        </span>
                    </div>

                    <!-- Champ : Confirmation du mot de passe -->
                    <div class="form-group <?= !empty($errors['mot_de_passe_confirm']) ? 'has-error' : '' ?>">
                        <label for="mot_de_passe_confirm">Confirmer le mot de passe <span class="required">*</span></label>
                        <input 
                            type="password" 
                            id="mot_de_passe_confirm" 
                            name="mot_de_passe_confirm" 
                            class="form-control" 
                            placeholder="Retapez votre mot de passe" 
                            required 
                            minlength="6"
                            autocomplete="new-password"
                        >
                        <span class="error-feedback" id="mot-de-passe-confirm-error">
                            <?= !empty($errors['mot_de_passe_confirm']) ? e($errors['mot_de_passe_confirm']) : '' ?>
                        </span>
                    </div>

                    <!-- Bouton de soumission -->
                    <button type="submit" id="btn-submit" class="btn btn-primary btn-block btn-lg">
                        Créer mon compte
                    </button>
                </form>

                <!-- Proposition de connexion -->
                <footer class="auth-footer">
                    <p>Vous possédez déjà un compte ? <a href="<?= url('login') ?>" class="auth-link">Se connecter</a></p>
                </footer>
            <?php endif; ?>

        </main>
    </div>

    <script src="<?= url('assets/js/main.js') ?>"></script>
</body>
</html>

