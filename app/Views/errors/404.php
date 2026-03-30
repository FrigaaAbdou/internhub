<?php

declare(strict_types=1);
?>
<section class="container error-page">
    <p class="eyebrow">Erreur <?= e((string) ($statusCode ?? 404)) ?></p>
    <h1>Ressource introuvable</h1>
    <p><?= e($message ?? 'La page demandee n existe pas ou n est plus disponible.') ?></p>
    <div class="hero__actions">
        <a class="button button--primary" href="<?= e(url('/')) ?>">Retour a l accueil</a>
    </div>
</section>
