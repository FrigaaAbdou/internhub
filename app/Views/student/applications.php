<?php

declare(strict_types=1);

$statusLabel = static function (?string $status): string {
    return match ((string) $status) {
        'envoyee' => 'Submitted',
        'en_cours' => 'In review',
        'acceptee' => 'Accepted',
        'refusee' => 'Declined',
        default => 'Updated',
    };
};

$formatDate = static function (?string $rawDate): string {
    if (! is_string($rawDate) || trim($rawDate) === '') {
        return 'Recent update';
    }

    $date = date_create($rawDate);

    return $date instanceof DateTimeInterface ? $date->format('d M Y') : 'Recent update';
};
?>
<section class="container student-applications-page">
    <div class="student-applications-page__hero">
        <div class="student-applications-page__copy">
            <span class="eyebrow">Student space</span>
            <h1>My applications</h1>
            <p class="lead">
                Review the status of every application you submitted and reopen the details or your uploaded CV whenever needed.
            </p>
        </div>

        <aside class="student-applications-page__hero-card">
            <span class="eyebrow">Overview</span>
            <h2><?= count($applications) ?> application<?= count($applications) > 1 ? 's' : '' ?> in your history</h2>
            <p class="meta">
                Status should stay more visible than date, and every line should lead quickly to the detailed view.
            </p>
        </aside>
    </div>
</section>

<section class="container student-applications-layout">
    <div class="student-applications-layout__main">
        <article class="student-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Applications list</span>
                    <h2>Track your submissions clearly.</h2>
                </div>
            </div>

            <?php if ($applications === []): ?>
                <div class="panel empty-state">
                    <h3>No applications submitted yet</h3>
                    <p>Start by exploring the published internships, then come back here to follow your submissions.</p>
                    <a class="button button--primary" href="<?= e(url('/offres')) ?>">Explore internships</a>
                </div>
            <?php else: ?>
                <div class="student-applications-list">
                    <?php foreach ($applications as $application): ?>
                        <article class="student-application-card">
                            <div class="student-application-card__header">
                                <div>
                                    <h3><?= e((string) $application['offer_title']) ?></h3>
                                    <p class="meta"><?= e((string) $application['company_name']) ?></p>
                                </div>
                                <span class="student-status-pill student-status-pill--<?= e((string) $application['status']) ?>">
                                    <?= e($statusLabel((string) $application['status'])) ?>
                                </span>
                            </div>

                            <div class="student-application-card__meta">
                                <span>Submitted on <?= e($formatDate((string) $application['created_at'])) ?></span>
                                <?php if (! empty($application['cv_path'])): ?>
                                    <span>CV available</span>
                                <?php else: ?>
                                    <span>No file available</span>
                                <?php endif; ?>
                            </div>

                            <div class="student-application-card__actions">
                                <a href="<?= e(url('/dashboard/etudiant/candidatures/' . $application['id'])) ?>">View detail</a>
                                <?php if (! empty($application['cv_path'])): ?>
                                    <a href="<?= e(url('/dashboard/etudiant/candidatures/' . $application['id'] . '/cv')) ?>">Download CV</a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>
    </div>

    <aside class="student-applications-layout__aside">
        <div class="student-dashboard-panel student-dashboard-panel--soft">
            <span class="eyebrow">Next step</span>
            <h2>Keep your search active.</h2>
            <p class="meta">
                Use this page to track the applications you already sent, then return to the offer directory or your wish-list when you want to continue exploring.
            </p>

            <div class="student-dashboard-panel__stack">
                <a class="button button--primary" href="<?= e(url('/offres')) ?>">Explore internships</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/etudiant/wishlist')) ?>">Open my wish-list</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/etudiant')) ?>">Back to dashboard</a>
            </div>
        </div>
    </aside>
</section>
