<?php

declare(strict_types=1);
?>
<section class="container support-error-page support-error-page--not-found">
    <div class="support-error-page__hero">
        <div class="support-error-page__copy">
            <span class="eyebrow">Error <?= e((string) ($statusCode ?? 404)) ?></span>
            <h1>Resource not found</h1>
            <p class="lead">
                <?= e($message ?? 'The page you requested does not exist, is no longer available, or has moved.') ?>
            </p>
        </div>

        <aside class="support-error-page__hero-card">
            <span class="eyebrow">What happened</span>
            <h2>The link is unavailable from this address.</h2>
            <p class="meta">
                The requested route could not be matched. You can continue from the main public pages or return to the homepage.
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
                    <h2>Continue from a valid page.</h2>
                </div>
            </div>

            <p class="meta">
                If you followed an outdated or incomplete link, start again from the public catalog, the company directory, or the homepage.
            </p>

            <div class="support-error-card__stack">
                <a class="button button--primary" href="<?= e(url('/offres')) ?>">Explore internships</a>
                <a class="button button--ghost" href="<?= e(url('/entreprises')) ?>">Browse companies</a>
                <a class="button button--ghost" href="<?= e(url('/')) ?>">Back to homepage</a>
            </div>
        </article>
    </div>

    <aside class="support-error-page__aside">
        <div class="support-error-card support-error-card--soft">
            <span class="eyebrow">Support context</span>
            <h2>Not every URL is permanent.</h2>
            <p class="meta">
                Some pages only exist inside protected flows, while others may have been renamed or removed. Public navigation links are the safest way to continue.
            </p>
        </div>
    </aside>
</section>
