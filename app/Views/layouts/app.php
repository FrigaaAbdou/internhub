<?php

declare(strict_types=1);

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isAuthScreen = $currentPath === '/login';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($metaTitle ?? config('app.name', 'InternHub')) ?></title>
    <meta name="description" content="<?= e($metaDescription ?? config('app.meta.default_description', 'InternHub')) ?>">
    <link rel="icon" type="image/png" href="<?= e(asset('/assets/mini-logo.png')) ?>">
    <link rel="apple-touch-icon" href="<?= e(asset('/assets/mini-logo.png')) ?>">
    <link rel="stylesheet" href="<?= e(asset('/assets/app.css')) ?>">
</head>
<body class="<?= $isAuthScreen ? 'is-auth-screen' : '' ?>">
<a class="skip-link" href="#main-content">Aller au contenu principal</a>
<?php if (! $isAuthScreen): ?>
    <?php \App\Core\View::partial('header'); ?>
<?php endif; ?>
<main id="main-content" class="page-shell<?= $isAuthScreen ? ' page-shell--auth' : '' ?>">
    <?php \App\Core\View::partial('flash'); ?>
    <?= $content ?>
</main>
<?php if (! $isAuthScreen): ?>
    <?php \App\Core\View::partial('footer'); ?>
<?php endif; ?>
</body>
</html>
