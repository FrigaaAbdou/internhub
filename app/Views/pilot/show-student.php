<?php

declare(strict_types=1);

$formatDate = static function (?string $rawDate): string {
    if (! is_string($rawDate) || trim($rawDate) === '') {
        return 'Recent update';
    }

    $date = date_create($rawDate);

    return $date instanceof DateTimeInterface ? $date->format('d M Y') : 'Recent update';
};
?>
<section class="container pilot-student-detail-page">
    <div class="pilot-student-detail-page__back">
        <a class="pilot-student-detail-page__back-link" href="<?= e(url('/dashboard/pilote/etudiants')) ?>">← Back to students</a>
    </div>

    <div class="pilot-student-detail-hero">
        <div class="pilot-student-detail-hero__copy">
            <span class="eyebrow">Student file</span>
            <h1><?= e((string) $student['first_name'] . ' ' . $student['last_name']) ?></h1>
            <p class="lead">
                Review this student’s identity and move directly into the applications view or account update workflow.
            </p>

            <ul class="pilot-student-detail-hero__meta">
                <li><?= e((string) $student['email']) ?></li>
                <li>Promotion <?= e((string) ($student['promotion_id'] ?? '')) ?></li>
            </ul>

            <div class="pilot-student-detail-hero__actions">
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants')) ?>">Back to students</a>
                <a class="button button--secondary" href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'] . '/candidatures')) ?>">View applications</a>
                <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'] . '/edit')) ?>">Edit account</a>
            </div>
        </div>

        <aside class="pilot-student-detail-hero__aside">
            <div class="pilot-student-detail-glance">
                <span class="eyebrow">Summary</span>
                <h2>Supervision snapshot</h2>
                <dl class="pilot-student-detail-glance__list">
                    <div>
                        <dt>Applications</dt>
                        <dd><?= e((string) $applicationCount) ?></dd>
                    </div>
                    <div>
                        <dt>Email</dt>
                        <dd><?= e((string) $student['email']) ?></dd>
                    </div>
                    <div>
                        <dt>Promotion</dt>
                        <dd><?= e((string) ($student['promotion_id'] ?? '')) ?></dd>
                    </div>
                </dl>
            </div>
        </aside>
    </div>
</section>

<section class="container pilot-student-detail-layout">
    <div class="pilot-student-detail-layout__main">
        <article class="pilot-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Recent applications</span>
                    <h2>Latest activity for this student.</h2>
                </div>
            </div>

            <?php if ($recentApplications === []): ?>
                <div class="panel empty-state">
                    <h3>No applications recorded</h3>
                    <p>This student does not currently have any applications in the platform.</p>
                    <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'] . '/edit')) ?>">Edit account</a>
                </div>
            <?php else: ?>
                <div class="pilot-student-detail-list">
                    <?php foreach ($recentApplications as $application): ?>
                        <article class="pilot-student-detail-card">
                            <div class="pilot-student-detail-card__header">
                                <div>
                                    <h3><?= e((string) $application['offer_title']) ?></h3>
                                    <p class="meta"><?= e((string) $application['company_name']) ?></p>
                                </div>
                                <span class="student-status-pill student-status-pill--<?= e((string) $application['status']) ?>">
                                    <?= e((string) $application['status']) ?>
                                </span>
                            </div>

                            <div class="pilot-student-detail-card__meta">
                                <span><?= e($formatDate((string) $application['created_at'])) ?></span>
                            </div>

                            <div class="pilot-student-detail-card__actions">
                                <a href="<?= e(url('/dashboard/pilote/candidatures/' . $application['id'])) ?>">View application</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>
    </div>

    <aside class="pilot-student-detail-layout__aside">
        <div class="pilot-dashboard-panel pilot-dashboard-panel--soft">
            <span class="eyebrow">Next step</span>
            <h2>Continue the supervision flow.</h2>
            <p class="meta">
                From this page, the pilot should move naturally to the student’s full applications list or to the account edit screen.
            </p>

            <div class="pilot-dashboard-panel__stack">
                <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'] . '/candidatures')) ?>">Open applications</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'] . '/edit')) ?>">Edit account</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants')) ?>">Back to roster</a>
            </div>
        </div>
    </aside>
</section>
