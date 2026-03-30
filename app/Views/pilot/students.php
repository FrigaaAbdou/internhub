<?php

declare(strict_types=1);
?>
<section class="container pilot-students-page">
    <div class="pilot-students-page__hero">
        <div class="pilot-students-page__copy">
            <span class="eyebrow">Pilot space</span>
            <h1>Students in the promotion</h1>
            <p class="lead">
                Review the full student roster attached to your promotion and move quickly into supervision, account maintenance, or application follow-up.
            </p>
        </div>

        <aside class="pilot-students-page__hero-card">
            <span class="eyebrow">Roster overview</span>
            <h2><?= count($students) ?> student<?= count($students) > 1 ? 's' : '' ?> currently in scope</h2>
            <p class="meta">
                This page should keep the promotion view readable and make the create-account action immediately visible.
            </p>
        </aside>
    </div>
</section>

<section class="container pilot-students-layout">
    <div class="pilot-students-layout__main">
        <article class="pilot-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Promotion roster</span>
                    <h2>Student records under your supervision.</h2>
                </div>
                <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants/create')) ?>">Create student account</a>
            </div>

            <?php if ($students === []): ?>
                <div class="panel empty-state">
                    <h3>No students attached yet</h3>
                    <p>Create the first student account to start supervising the promotion.</p>
                    <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants/create')) ?>">Create student account</a>
                </div>
            <?php else: ?>
                <div class="pilot-students-list">
                    <?php foreach ($students as $student): ?>
                        <article class="pilot-student-card">
                            <div class="pilot-student-card__header">
                                <div>
                                    <h3><?= e((string) $student['first_name'] . ' ' . $student['last_name']) ?></h3>
                                    <p class="meta"><?= e((string) $student['email']) ?></p>
                                </div>
                            </div>

                            <div class="pilot-student-card__actions">
                                <a href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'])) ?>">View profile</a>
                                <a href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'] . '/candidatures')) ?>">Applications</a>
                                <a href="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'] . '/edit')) ?>">Edit</a>
                                <form method="post" action="<?= e(url('/dashboard/pilote/etudiants/' . $student['id'] . '/delete')) ?>" class="inline-form">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="button-link danger-link">Delete</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>
    </div>

    <aside class="pilot-students-layout__aside">
        <div class="pilot-dashboard-panel pilot-dashboard-panel--soft">
            <span class="eyebrow">Navigation logic</span>
            <h2>Move from roster to follow-up.</h2>
            <p class="meta">
                This page is the entry point to each student record. From here, the pilot should move into student detail, applications, and account updates without confusion.
            </p>

            <div class="pilot-dashboard-panel__stack">
                <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants/create')) ?>">Create student account</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote')) ?>">Back to dashboard</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/offres')) ?>">Manage offers</a>
            </div>
        </div>
    </aside>
</section>
