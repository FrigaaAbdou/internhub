<?php

declare(strict_types=1);
?>
<section class="container support-error-page support-error-page--server">
    <div class="support-error-page__hero">
        <div class="support-error-page__copy">
            <span class="eyebrow">Error <?= e((string) ($statusCode ?? 500)) ?></span>
            <h1>Technical error</h1>
            <p class="lead">
                <?= e($message ?? 'A technical error occurred. Please try again later.') ?>
            </p>
        </div>

        <aside class="support-error-page__hero-card">
            <span class="eyebrow">What happened</span>
            <h2>The request could not be completed safely.</h2>
            <p class="meta">
                InternHub encountered an internal problem while processing the page. You can return to a stable route and try again from there.
            </p>
        </aside>
    </div>
</section>

<section class="container support-error-page__content">
    <div class="support-error-page__main">
        <article class="support-error-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Next step</span>
                    <h2>Go back to a safe entry point.</h2>
                </div>
            </div>

            <p class="meta">
                Start again from the homepage or from a stable public route. If the issue persists, the demonstration environment may need to be refreshed.
            </p>

            <div class="support-error-card__stack">
                <a class="button button--primary" href="<?= e(url('/')) ?>">Back to homepage</a>
                <a class="button button--ghost" href="<?= e(url('/offres')) ?>">Explore internships</a>
                <a class="button button--ghost" href="<?= e(url('/mentions-legales')) ?>">Open legal mentions</a>
            </div>

            <?php if (! empty($debugTrace)): ?>
                <details class="debug-trace">
                    <summary>Technical trace</summary>
                    <pre><?= e((string) $debugTrace) ?></pre>
                </details>
            <?php endif; ?>
        </article>
    </div>

    <aside class="support-error-page__aside">
        <div class="support-error-card support-error-card--soft">
            <span class="eyebrow">Support context</span>
            <h2>Unexpected failures stay isolated.</h2>
            <p class="meta">
                This screen is designed to stop the failure chain cleanly, protect the rest of the interface, and give users a clear way back into the application.
            </p>
        </div>
    </aside>
</section>
