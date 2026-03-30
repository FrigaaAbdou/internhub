<?php

declare(strict_types=1);

$role = auth_role();
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isLanding = ! auth_check() && $currentPath === '/';
?>
<header class="site-header">
    <div class="container site-header__inner">
        <a class="brand" href="<?= e(url('/')) ?>">
            <img class="brand__logo" src="<?= e(asset('/assets/mini-logo.png')) ?>" alt="" aria-hidden="true">
            <span><?= e(config('app.name', 'InternHub')) ?></span>
        </a>
        <?php if ($isLanding): ?>
            <nav class="site-nav site-nav--landing" aria-label="Navigation principale">
                <a href="#product">Product</a>
                <a href="#how-it-works">How it works</a>
                <a href="#for-schools">For schools</a>
            </nav>
        <?php else: ?>
            <nav class="site-nav" aria-label="Navigation principale">
                <a href="<?= e(url('/')) ?>">Accueil</a>
                <a href="<?= e(url('/offres')) ?>">Offres</a>
                <a href="<?= e(url('/entreprises')) ?>">Entreprises</a>
                <a href="<?= e(url('/statistiques')) ?>">Statistiques</a>
                <?php if ($role === 'etudiant'): ?>
                    <a href="<?= e(url('/dashboard/etudiant')) ?>">Dashboard</a>
                    <a href="<?= e(url('/dashboard/etudiant/profil')) ?>">Mon profil</a>
                    <a href="<?= e(url('/dashboard/etudiant/candidatures')) ?>">Mes candidatures</a>
                    <a href="<?= e(url('/dashboard/etudiant/wishlist')) ?>">Ma wish-list</a>
                <?php elseif ($role === 'pilote'): ?>
                    <a href="<?= e(url('/dashboard/pilote')) ?>">Dashboard pilote</a>
                    <a href="<?= e(url('/dashboard/pilote/etudiants')) ?>">Etudiants</a>
                    <a href="<?= e(url('/dashboard/pilote/entreprises')) ?>">Gestion entreprises</a>
                    <a href="<?= e(url('/dashboard/pilote/offres')) ?>">Gestion offres</a>
                <?php elseif ($role === 'administrateur'): ?>
                    <a href="<?= e(url('/dashboard/admin')) ?>">Dashboard admin</a>
                    <a href="<?= e(url('/admin/comptes')) ?>">Comptes</a>
                    <a href="<?= e(url('/admin/entreprises')) ?>">Gestion entreprises</a>
                    <a href="<?= e(url('/admin/offres')) ?>">Gestion offres</a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
        <div class="site-header__actions">
            <?php if (auth_check()): ?>
                <span class="role-pill"><?= e((string) auth_user()['role']) ?></span>
                <form action="<?= e(url('/logout')) ?>" method="post" class="inline-form">
                    <?= csrf_field() ?>
                    <button type="submit" class="button button--secondary">Deconnexion</button>
                </form>
            <?php elseif ($isLanding): ?>
                <a class="button button--ghost" href="<?= e(url('/login')) ?>">Sign in</a>
                <a class="button button--primary" href="<?= e(url('/offres')) ?>">Explore internships</a>
            <?php else: ?>
                <a class="button button--secondary" href="<?= e(url('/login')) ?>">Connexion</a>
            <?php endif; ?>
        </div>
    </div>
</header>
