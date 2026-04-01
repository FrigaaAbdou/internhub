<?php

declare(strict_types=1);

$role = auth_role();
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isLanding = ! auth_check() && $currentPath === '/';

$navLinks = $isLanding
    ? [
        ['href' => '#product', 'label' => 'Product'],
        ['href' => '#how-it-works', 'label' => 'How it works'],
        ['href' => '#for-schools', 'label' => 'For schools'],
    ]
    : [
        ['href' => url('/'), 'label' => 'Accueil'],
        ['href' => url('/offres'), 'label' => 'Offres'],
        ['href' => url('/entreprises'), 'label' => 'Entreprises'],
        ['href' => url('/statistiques'), 'label' => 'Statistiques'],
    ];

if ($role === 'etudiant') {
    $navLinks = array_merge($navLinks, [
        ['href' => url('/dashboard/etudiant'), 'label' => 'Dashboard'],
        ['href' => url('/dashboard/etudiant/profil'), 'label' => 'Mon profil'],
        ['href' => url('/dashboard/etudiant/candidatures'), 'label' => 'Mes candidatures'],
        ['href' => url('/dashboard/etudiant/wishlist'), 'label' => 'Ma wish-list'],
    ]);
} elseif ($role === 'pilote') {
    $navLinks = array_merge($navLinks, [
        ['href' => url('/dashboard/pilote'), 'label' => 'Dashboard pilote'],
        ['href' => url('/dashboard/pilote/etudiants'), 'label' => 'Etudiants'],
        ['href' => url('/dashboard/pilote/entreprises'), 'label' => 'Gestion entreprises'],
        ['href' => url('/dashboard/pilote/offres'), 'label' => 'Gestion offres'],
    ]);
} elseif ($role === 'administrateur') {
    $navLinks = array_merge($navLinks, [
        ['href' => url('/dashboard/admin'), 'label' => 'Dashboard admin'],
        ['href' => url('/admin/comptes'), 'label' => 'Comptes'],
        ['href' => url('/admin/entreprises'), 'label' => 'Gestion entreprises'],
        ['href' => url('/admin/offres'), 'label' => 'Gestion offres'],
    ]);
}

$mobileMenuId = 'mobile-menu-panel';
?>
<header class="site-header">
    <div class="container site-header__inner">
        <a class="brand" href="<?= e(url('/')) ?>">
            <img class="brand__logo" src="<?= e(asset('/assets/mini-logo.png')) ?>" alt="" aria-hidden="true">
            <span><?= e(config('app.name', 'InternHub')) ?></span>
        </a>
        <nav class="site-nav<?= $isLanding ? ' site-nav--landing' : '' ?>" aria-label="Navigation principale">
            <?php foreach ($navLinks as $link): ?>
                <a href="<?= e((string) $link['href']) ?>"><?= e((string) $link['label']) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="site-header__actions site-header__actions--desktop">
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
        <button
            type="button"
            class="header-toggle"
            aria-label="Ouvrir le menu"
            aria-expanded="false"
            aria-controls="<?= e($mobileMenuId) ?>"
            data-mobile-menu-toggle
        >
            <span class="header-toggle__line"></span>
            <span class="header-toggle__line"></span>
            <span class="header-toggle__line"></span>
        </button>
    </div>
</header>
<div class="mobile-menu" data-mobile-menu>
    <button type="button" class="mobile-menu__backdrop" aria-label="Fermer le menu" data-mobile-menu-close></button>
    <aside class="mobile-menu__panel" id="<?= e($mobileMenuId) ?>" aria-label="Menu mobile" tabindex="-1">
        <div class="mobile-menu__header">
            <a class="brand" href="<?= e(url('/')) ?>">
                <img class="brand__logo" src="<?= e(asset('/assets/mini-logo.png')) ?>" alt="" aria-hidden="true">
                <span><?= e(config('app.name', 'InternHub')) ?></span>
            </a>
            <button type="button" class="mobile-menu__close" aria-label="Fermer le menu" data-mobile-menu-close>
                <span></span>
                <span></span>
            </button>
        </div>
        <nav class="mobile-menu__nav" aria-label="Navigation mobile">
            <?php foreach ($navLinks as $link): ?>
                <a href="<?= e((string) $link['href']) ?>"><?= e((string) $link['label']) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="mobile-menu__actions">
            <?php if (auth_check()): ?>
                <span class="role-pill"><?= e((string) auth_user()['role']) ?></span>
                <form action="<?= e(url('/logout')) ?>" method="post" class="mobile-menu__form">
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
    </aside>
</div>
