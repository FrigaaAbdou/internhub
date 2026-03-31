<?php

declare(strict_types=1);
?>
<section class="container legal-page">
    <div class="legal-page__hero">
        <div class="legal-page__copy">
            <span class="eyebrow">Legal support</span>
            <h1>Legal mentions</h1>
            <p class="lead">
                This page defines the minimum publication framework for the demonstration version of <?= e($appName) ?>. The project is presented as an academic application, not as a public commercial service.
            </p>
        </div>

        <aside class="legal-page__hero-card">
            <span class="eyebrow">Document scope</span>
            <h2>Demonstration-first legal framing</h2>
            <p class="meta">
                These mentions clarify publisher identity, hosting context, data posture, and the educational nature of the platform. They are intentionally concise for a demonstration environment.
            </p>
        </aside>
    </div>
</section>

<section class="container legal-page__content">
    <div class="legal-page__main">
        <article class="legal-card" id="about">
            <h2>Publisher</h2>
            <ul class="check-list">
                <li><strong>Name:</strong> <?= e($publisher) ?></li>
                <li><strong>Publication director:</strong> <?= e($director) ?></li>
                <li><strong>Contact:</strong> <a href="mailto:<?= e($contactEmail) ?>"><?= e($contactEmail) ?></a></li>
            </ul>
        </article>

        <article class="legal-card">
            <h2>Hosting</h2>
            <p><?= e($hosting) ?></p>
            <p class="meta">
                This statement remains intentionally simple because the project is mainly used in a local or demonstration environment.
            </p>
        </article>

        <article class="legal-card" id="donnees-personnelles">
            <h2>Personal data</h2>
            <p>
                The data displayed in this instance is used for technical demonstration purposes. It should not be considered a production database or a public-facing data-processing environment.
            </p>
            <p>
                For a real deployment, a dedicated privacy policy, a retention framework, and deletion procedures would need to be added.
            </p>
        </article>

        <article class="legal-card">
            <h2>Intellectual property</h2>
            <p>
                The content, screens, navigation structures, and application elements of this demonstration remain tied to the academic project <?= e($appName) ?>. Any reuse in a public context should be reviewed before publication.
            </p>
        </article>
    </div>

    <aside class="legal-page__aside">
        <div class="legal-card legal-card--soft">
            <span class="eyebrow">Support links</span>
            <h2>Useful public references</h2>
            <p class="meta">
                From here, users should be able to move toward the product, explore the public catalog, or contact the project owner without leaving the support context.
            </p>

            <div class="legal-card__stack">
                <a class="button button--primary" href="<?= e(url('/')) ?>">Back to homepage</a>
                <a class="button button--ghost" href="<?= e(url('/offres')) ?>">Explore internships</a>
                <a class="button button--ghost" href="<?= e(url('/entreprises')) ?>">Browse companies</a>
            </div>
        </div>
    </aside>
</section>
