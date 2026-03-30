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
<section class="container pilot-dashboard">
    <div class="pilot-dashboard__hero">
        <div class="pilot-dashboard__copy">
            <span class="eyebrow">Pilot space</span>
            <h1>Pilot dashboard</h1>
            <p class="lead">
                Supervise your promotion, monitor recent application activity, and move quickly to the next administrative action.
            </p>
        </div>

        <aside class="pilot-dashboard__hero-card">
            <span class="eyebrow">Promotion overview</span>
            <h2>Academic supervision in one space</h2>
            <p class="meta">
                This dashboard is designed for clarity and responsibility: understand your promotion, access student records, and manage the supporting workflow.
            </p>
        </aside>
    </div>

    <div class="pilot-dashboard__stats">
        <article class="pilot-stat-card">
            <span class="pilot-stat-card__label">Students followed</span>
            <strong><?= e((string) $studentCount) ?></strong>
            <p>Students currently attached to your promotion.</p>
        </article>
        <article class="pilot-stat-card">
            <span class="pilot-stat-card__label">Promotion applications</span>
            <strong><?= e((string) $applicationCount) ?></strong>
            <p>Total applications submitted inside your supervision scope.</p>
        </article>
    </div>
</section>

<section class="container pilot-dashboard-sections">
    <div class="pilot-dashboard-sections__main">
        <article class="pilot-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Quick actions</span>
                    <h2>Go directly to the next supervision task.</h2>
                </div>
            </div>

            <div class="pilot-quick-grid">
                <a class="pilot-quick-card pilot-quick-card--primary" href="<?= e(url('/dashboard/pilote/etudiants')) ?>">
                    <h3>Students</h3>
                    <p>Open the promotion roster and move into student-level supervision.</p>
                    <span>Open →</span>
                </a>
                <a class="pilot-quick-card" href="<?= e(url('/dashboard/pilote/etudiants/create')) ?>">
                    <h3>Create account</h3>
                    <p>Add a student account within your promotion perimeter.</p>
                    <span>Open →</span>
                </a>
                <a class="pilot-quick-card" href="<?= e(url('/dashboard/pilote/entreprises')) ?>">
                    <h3>Manage companies</h3>
                    <p>Keep partner-company records clean and usable for the internship workflow.</p>
                    <span>Open →</span>
                </a>
                <a class="pilot-quick-card" href="<?= e(url('/dashboard/pilote/offres')) ?>">
                    <h3>Manage offers</h3>
                    <p>Review the internship opportunities published through the platform.</p>
                    <span>Open →</span>
                </a>
                <a class="pilot-quick-card" href="<?= e(url('/statistiques')) ?>">
                    <h3>Statistics</h3>
                    <p>Open the shared statistics page for broader platform visibility.</p>
                    <span>Open →</span>
                </a>
            </div>
        </article>

        <article class="pilot-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Recent promotion activity</span>
                    <h2>Latest application events inside your scope.</h2>
                </div>
            </div>

            <?php if ($recentApplications === []): ?>
                <div class="panel empty-state">
                    <h3>No recent application activity</h3>
                    <p>The promotion currently has no recent applications to review.</p>
                    <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants')) ?>">Open student list</a>
                </div>
            <?php else: ?>
                <div class="pilot-activity-list">
                    <?php foreach ($recentApplications as $application): ?>
                        <article class="pilot-activity-card">
                            <div class="pilot-activity-card__header">
                                <div>
                                    <h3><?= e((string) $application['student_first_name'] . ' ' . $application['student_last_name']) ?></h3>
                                    <p class="meta"><?= e((string) $application['offer_title']) ?> · <?= e((string) $application['company_name']) ?></p>
                                </div>
                                <span class="student-status-pill student-status-pill--<?= e((string) $application['status']) ?>">
                                    <?= e((string) $application['status']) ?>
                                </span>
                            </div>

                            <div class="pilot-activity-card__meta">
                                <span><?= e($formatDate((string) $application['created_at'])) ?></span>
                            </div>

                            <div class="pilot-activity-card__actions">
                                <a href="<?= e(url('/dashboard/pilote/candidatures/' . $application['id'])) ?>">View application</a>
                                <a href="<?= e(url('/dashboard/pilote/etudiants/' . $application['student_id'] . '/candidatures')) ?>">Open student file</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>
    </div>

    <aside class="pilot-dashboard-sections__aside">
        <div class="pilot-dashboard-panel pilot-dashboard-panel--soft">
            <span class="eyebrow">Piloting logic</span>
            <h2>Move from global view to student detail.</h2>
            <p class="meta">
                The pilot workflow should stay readable: dashboard, student roster, student file, applications, then application detail.
            </p>

            <div class="pilot-dashboard-panel__stack">
                <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants')) ?>">Open students</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants/create')) ?>">Create student account</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/offres')) ?>">Manage offers</a>
            </div>
        </div>
    </aside>
</section>
