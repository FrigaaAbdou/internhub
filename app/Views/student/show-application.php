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

$cvFile = ! empty($application['cv_path']) ? basename((string) $application['cv_path']) : null;
?>
<section class="container student-application-detail-page">
    <div class="student-application-detail-page__back">
        <a class="student-application-detail-page__back-link" href="<?= e(url('/dashboard/etudiant/candidatures')) ?>">← Back to my applications</a>
    </div>

    <div class="student-application-detail-hero">
        <div class="student-application-detail-hero__copy">
            <span class="eyebrow">Application detail</span>
            <h1><?= e((string) $application['offer_title']) ?></h1>
            <p class="lead">
                Review the key information for this submission and reopen the offer or your uploaded CV without ambiguity.
            </p>

            <ul class="student-application-detail-hero__meta">
                <li><?= e((string) $application['company_name']) ?></li>
                <li><?= e((string) $application['offer_location']) ?></li>
                <li><?= e((string) $application['contract_type']) ?></li>
            </ul>

            <div class="student-application-detail-hero__actions">
                <a class="button button--ghost" href="<?= e(url('/dashboard/etudiant/candidatures')) ?>">Back to applications</a>
                <a class="button button--secondary" href="<?= e(url('/offres/' . $application['offer_id'])) ?>">View internship</a>
                <?php if ($cvFile !== null): ?>
                    <a class="button button--primary" href="<?= e(url('/dashboard/etudiant/candidatures/' . $application['id'] . '/cv')) ?>">Download my CV</a>
                <?php endif; ?>
            </div>
        </div>

        <aside class="student-application-detail-hero__aside">
            <div class="student-application-detail-glance">
                <span class="eyebrow">Follow-up</span>
                <h2>Current application status</h2>
                <dl class="student-application-detail-glance__list">
                    <div>
                        <dt>Status</dt>
                        <dd><span class="student-status-pill student-status-pill--<?= e((string) $application['status']) ?>"><?= e($statusLabel((string) $application['status'])) ?></span></dd>
                    </div>
                    <div>
                        <dt>Submitted on</dt>
                        <dd><?= e($formatDate((string) $application['created_at'])) ?></dd>
                    </div>
                    <div>
                        <dt>CV file</dt>
                        <dd><?= e($cvFile ?? 'No file available') ?></dd>
                    </div>
                </dl>
            </div>
        </aside>
    </div>
</section>

<section class="container student-application-detail-layout">
    <div class="student-application-detail-layout__main">
        <article class="student-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Motivation letter</span>
                    <h2>Your submitted message</h2>
                </div>
            </div>

            <div class="student-application-detail-copy">
                <?php foreach (preg_split('/\R+/', (string) ($application['cover_letter'] ?? '')) ?: [] as $paragraph): ?>
                    <?php $paragraph = trim((string) $paragraph); ?>
                    <?php if ($paragraph !== ''): ?>
                        <p><?= e($paragraph) ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </article>
    </div>

    <aside class="student-application-detail-layout__aside">
        <div class="student-dashboard-panel student-dashboard-panel--soft">
            <span class="eyebrow">Next action</span>
            <h2>Keep the context clear.</h2>
            <p class="meta">
                This page should let you understand what was submitted, check the current status, and move back to the internship or your full applications list.
            </p>

            <div class="student-dashboard-panel__stack">
                <a class="button button--primary" href="<?= e(url('/dashboard/etudiant/candidatures')) ?>">Back to applications</a>
                <a class="button button--ghost" href="<?= e(url('/offres/' . $application['offer_id'])) ?>">Open internship detail</a>
                <?php if ($cvFile !== null): ?>
                    <a class="button button--ghost" href="<?= e(url('/dashboard/etudiant/candidatures/' . $application['id'] . '/cv')) ?>">Download current CV</a>
                <?php endif; ?>
            </div>
        </div>
    </aside>
</section>
