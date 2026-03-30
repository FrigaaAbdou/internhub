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
<section class="container pilot-application-detail-page">
    <div class="pilot-application-detail-page__back">
        <a class="pilot-application-detail-page__back-link" href="<?= e(url('/dashboard/pilote/etudiants/' . $application['student_id'] . '/candidatures')) ?>">← Back to student applications</a>
    </div>

    <div class="pilot-application-detail-hero">
        <div class="pilot-application-detail-hero__copy">
            <span class="eyebrow">Application detail</span>
            <h1><?= e((string) $application['offer_title']) ?></h1>
            <p class="lead">
                Review this application in its supervision context, access the student record, and open the supporting CV file when it is available.
            </p>

            <ul class="pilot-application-detail-hero__meta">
                <li><?= e((string) $application['company_name']) ?></li>
                <li><?= e((string) $application['offer_location']) ?></li>
                <li><?= e((string) $application['contract_type']) ?></li>
            </ul>

            <div class="pilot-application-detail-hero__actions">
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants/' . $application['student_id'] . '/candidatures')) ?>">Back to applications</a>
                <a class="button button--secondary" href="<?= e(url('/offres/' . $application['offer_id'])) ?>">View internship</a>
                <?php if ($cvFile !== null): ?>
                    <a class="button button--primary" href="<?= e(url('/dashboard/pilote/candidatures/' . $application['id'] . '/cv')) ?>">Download CV</a>
                <?php endif; ?>
            </div>
        </div>

        <aside class="pilot-application-detail-hero__aside">
            <div class="pilot-application-detail-glance">
                <span class="eyebrow">Follow-up</span>
                <h2>Current supervision status</h2>
                <dl class="pilot-application-detail-glance__list">
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

<section class="container pilot-application-detail-layout">
    <div class="pilot-application-detail-layout__main">
        <article class="pilot-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Student</span>
                    <h2>Student linked to this application</h2>
                </div>
            </div>

            <div class="pilot-application-detail-student">
                <div>
                    <h3><?= e((string) $application['student_first_name'] . ' ' . $application['student_last_name']) ?></h3>
                    <p class="meta">Student record available inside your promotion scope.</p>
                </div>
                <a class="button button--secondary" href="<?= e(url('/dashboard/pilote/etudiants/' . $application['student_id'])) ?>">Open student profile</a>
            </div>
        </article>

        <article class="pilot-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Motivation letter</span>
                    <h2>Submitted message</h2>
                </div>
            </div>

            <div class="pilot-application-detail-copy">
                <?php foreach (preg_split('/\R+/', (string) ($application['cover_letter'] ?? '')) ?: [] as $paragraph): ?>
                    <?php $paragraph = trim((string) $paragraph); ?>
                    <?php if ($paragraph !== ''): ?>
                        <p><?= e($paragraph) ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </article>
    </div>

    <aside class="pilot-application-detail-layout__aside">
        <div class="pilot-dashboard-panel pilot-dashboard-panel--soft">
            <span class="eyebrow">Next step</span>
            <h2>Keep the supervision path readable.</h2>
            <p class="meta">
                This page should let the pilot return to the student applications list, open the student profile, or inspect the internship itself without losing context.
            </p>

            <div class="pilot-dashboard-panel__stack">
                <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants/' . $application['student_id'] . '/candidatures')) ?>">Back to applications</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants/' . $application['student_id'])) ?>">Open student profile</a>
                <a class="button button--ghost" href="<?= e(url('/offres/' . $application['offer_id'])) ?>">Open internship</a>
            </div>
        </div>
    </aside>
</section>
