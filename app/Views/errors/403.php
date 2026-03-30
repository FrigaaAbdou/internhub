<?php

declare(strict_types=1);
?>
<section class="container error-page">
    <p class="eyebrow">Erreur <?= e((string) ($statusCode ?? 403)) ?></p>
    <h1>Acces refuse</h1>
    <p><?= e($message ?? 'Vous n avez pas les droits necessaires pour acceder a cette ressource.') ?></p>
    <div class="hero__actions">
        <a class="button button--primary" href="<?= e(url('/')) ?>">Retour a l accueil</a>
    </div>
</section>
