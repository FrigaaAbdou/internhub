<?php

declare(strict_types=1);
?>
<section class="container error-page">
    <p class="eyebrow">Erreur <?= e((string) ($statusCode ?? 500)) ?></p>
    <h1>Erreur technique</h1>
    <p><?= e($message ?? 'Une erreur technique est survenue. Merci de reessayer plus tard.') ?></p>
    <?php if (! empty($debugTrace)): ?>
        <details class="debug-trace">
            <summary>Trace technique</summary>
            <pre><?= e((string) $debugTrace) ?></pre>
        </details>
    <?php endif; ?>
    <div class="hero__actions">
        <a class="button button--primary" href="<?= e(url('/')) ?>">Retour a l accueil</a>
    </div>
</section>
