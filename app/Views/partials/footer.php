<?php

declare(strict_types=1);

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isLanding = ! auth_check() && $currentPath === '/';
?>
<footer class="site-footer">
    <div class="container site-footer__inner">
        <?php if ($isLanding): ?>
            <div class="site-footer__meta">
                <a class="brand brand--footer" href="<?= e(url('/')) ?>">
                    <img class="brand__logo" src="<?= e(asset('/assets/mini-logo.png')) ?>" alt="" aria-hidden="true">
                    <span><?= e(config('app.name', 'InternHub')) ?></span>
                </a>
                <p class="meta">
                    Internship management for students, coordinators, and academic teams in one structured platform.
                </p>
            </div>
            <div class="footer-columns">
                <nav class="footer-nav" aria-label="Liens produit">
                    <span class="footer-nav__title">Product</span>
                    <a href="#product">About</a>
                    <a href="#for-schools">For schools</a>
                    <a href="#how-it-works">How it works</a>
                </nav>
                <nav class="footer-nav" aria-label="Liens support">
                    <span class="footer-nav__title">Support</span>
                    <a href="mailto:contact@internhub.test">Contact</a>
                    <a href="<?= e(url('/mentions-legales')) ?>">Legal mentions</a>
                    <a href="<?= e(url('/mentions-legales')) ?>#donnees-personnelles">Privacy policy</a>
                </nav>
            </div>
        <?php else: ?>
            <div class="site-footer__meta">
                <p><?= e(config('app.name', 'InternHub')) ?> · projet pedagogique de demonstration.</p>
                <p class="meta">Etat actuel : socle, modules coeur, modules avances et lot de stabilisation en cours.</p>
            </div>
            <nav class="footer-nav" aria-label="Navigation de pied de page">
                <a href="<?= e(url('/mentions-legales')) ?>">Mentions legales</a>
                <a href="<?= e(url('/health')) ?>">Health</a>
            </nav>
        <?php endif; ?>
    </div>
</footer>
