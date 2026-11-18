<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Speech English</title>
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body class="auth-body">

    <div class="auth-wrapper">
        <header class="auth-header">
            <div class="brand-logo">
                <span class="logo-circle">SE</span>
                <span class="brand-title">Speech English</span>
            </div>
            <p class="brand-tagline">Apprenez la grammaire anglaise, étape par étape.</p>
        </header>

        <main class="auth-card">
            <div class="form-title-group">
                <h1>Connexion</h1>
                <p class="form-subtitle">Entrez vos identifiants pour accéder à vos leçons et à vos quiz.</p>
            </div>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success" role="alert">
                    <?= e($success) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form action="<?= url('login') ?>" method="POST" autocomplete="on">
                <div class="form-group">
                    <label for="login-email">Adresse email</label>
                    <input 
                        type="email" 
                        id="login-email" 
                        name="email" 
                        class="form-control" 
                        placeholder="nom@exemple.com" 
                        required 
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label for="login-password">Mot de passe</label>
                    <input 
                        type="password" 
                        id="login-password" 
                        name="password" 
                        class="form-control" 
                        placeholder="••••••••" 
                        required 
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    Se connecter
                </button>
            </form>

            <footer class="auth-footer">
                <p>Pas encore inscrit ? <a href="<?= url('register') ?>" class="auth-link">Créer un compte</a></p>
            </footer>
        </main>
    </div>

</body>
</html>

