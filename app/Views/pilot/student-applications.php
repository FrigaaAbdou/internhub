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
<section class="container pilot-student-applications-page">
    <div class="pilot-student-applications-page__hero">
        <div class="pilot-student-applications-page__copy">
            <span class="eyebrow">Pilot space</span>
            <h1>Applications of <?= e((string) $student['first_name'] . ' ' . $student['last_name']) ?></h1>
            <p class="lead">
                Inspect this student’s applications in one view and move directly to the detailed supervision screen or the CV file when available.
            </p>
        </div>

        <aside class="pilot-student-applications-page__hero-card">
            <span class="eyebrow">Student context</span>
            <h2><?= count($applications) ?> application<?= count($applications) > 1 ? 's' : '' ?> in this file</h2>
            <p class="meta">
                This view should make it easy to move back to the roster or back to the student profile without losing the supervision context.
            </p>
        </aside>
    </div>
</section>

<section class="container pilot-student-applications-layout">
    <div class="pilot-student-applications-layout__main">
        <article class="pilot-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Applications list</span>
                    <h2>Review this student’s submission history.</h2>
                </div>
                <div class="pilot-student-applications-layout__actions">
                    <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants')) ?>">Back to students</a>
                    <a class="button button--secondary" href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'])) ?>">Student profile</a>
                </div>
            </div>

            <?php if ($applications === []): ?>
                <div class="panel empty-state">
                    <h3>No applications recorded</h3>
                    <p>This student does not currently have any applications in the platform.</p>
                    <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'])) ?>">Back to student profile</a>
                </div>
            <?php else: ?>
                <div class="pilot-student-applications-list">
                    <?php foreach ($applications as $application): ?>
                        <article class="pilot-student-application-card">
                            <div class="pilot-student-application-card__header">
                                <div>
                                    <h3><?= e((string) $application['offer_title']) ?></h3>
                                    <p class="meta"><?= e((string) $application['company_name']) ?></p>
                                </div>
                                <span class="student-status-pill student-status-pill--<?= e((string) $application['status']) ?>">
                                    <?= e($statusLabel((string) $application['status'])) ?>
                                </span>
                            </div>

                            <div class="pilot-student-application-card__meta">
                                <span><?= e($formatDate((string) $application['created_at'])) ?></span>
                                <?php if (! empty($application['cv_path'])): ?>
                                    <span>CV available</span>
                                <?php else: ?>
                                    <span>No file available</span>
                                <?php endif; ?>
                            </div>

                            <div class="pilot-student-application-card__actions">
                                <a href="<?= e(url('/dashboard/pilote/candidatures/' . $application['id'])) ?>">View application</a>
                                <?php if (! empty($application['cv_path'])): ?>
                                    <a href="<?= e(url('/dashboard/pilote/candidatures/' . $application['id'] . '/cv')) ?>">Download CV</a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>
    </div>

    <aside class="pilot-student-applications-layout__aside">
        <div class="pilot-dashboard-panel pilot-dashboard-panel--soft">
            <span class="eyebrow">Supervision flow</span>
            <h2>From student file to application detail.</h2>
            <p class="meta">
                This screen is the bridge between the student profile and the individual application detail page, so the return paths should stay obvious.
            </p>

            <div class="pilot-dashboard-panel__stack">
                <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'])) ?>">Open student profile</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants')) ?>">Back to roster</a>
            </div>
        </div>
    </aside>
</section>
