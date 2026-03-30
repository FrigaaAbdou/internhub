<?php

declare(strict_types=1);

$pilotCount = 0;
$studentCount = 0;

foreach ($accounts as $account) {
    if ((string) ($account['role'] ?? '') === 'pilote') {
        $pilotCount++;
    }

    if ((string) ($account['role'] ?? '') === 'etudiant') {
        $studentCount++;
    }
}
?>
<section class="container admin-accounts-page">
    <div class="admin-accounts__hero">
        <div class="admin-accounts__copy">
            <span class="eyebrow">Admin space</span>
            <h1>Accounts</h1>
            <p class="lead">
                Manage pilot and student access from one governance view, with role clarity and reliable edit and deletion actions.
            </p>
        </div>

        <aside class="admin-accounts__hero-card">
            <span class="eyebrow">Overview</span>
            <h2>Platform access distribution</h2>
            <div class="admin-accounts__summary">
                <div>
                    <dt>Pilot accounts</dt>
                    <dd><?= e((string) $pilotCount) ?></dd>
                </div>
                <div>
                    <dt>Student accounts</dt>
                    <dd><?= e((string) $studentCount) ?></dd>
                </div>
                <div>
                    <dt>Total accounts</dt>
                    <dd><?= e((string) count($accounts)) ?></dd>
                </div>
            </div>
        </aside>
    </div>
</section>

<section class="container admin-accounts__content">
    <div class="admin-accounts__main">
        <article class="admin-dashboard-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Account management</span>
                    <h2>Review and maintain access.</h2>
                </div>
                <a class="button button--primary" href="<?= e(url('/admin/comptes/create')) ?>">Create account</a>
            </div>

            <?php if ($accounts === []): ?>
                <div class="empty-state">
                    <h2>No accounts available</h2>
                    <p>Create the first account to open platform access management.</p>
                </div>
            <?php else: ?>
                <div class="admin-accounts-list">
                    <?php foreach ($accounts as $account): ?>
                        <article class="admin-account-card">
                            <div class="admin-account-card__header">
                                <div>
                                    <h3><?= e((string) $account['first_name'] . ' ' . $account['last_name']) ?></h3>
                                    <p class="meta"><?= e((string) $account['email']) ?></p>
                                </div>

                                <span class="admin-role-pill admin-role-pill--<?= e((string) $account['role']) ?>">
                                    <?= e((string) $account['role']) ?>
                                </span>
                            </div>

                            <dl class="admin-account-card__meta">
                                <div>
                                    <dt>Promotion</dt>
                                    <dd><?= e((string) ($account['promotion_id'] ?? '-')) ?></dd>
                                </div>
                                <div>
                                    <dt>Access type</dt>
                                    <dd><?= (string) ($account['role'] ?? '') === 'pilote' ? 'Coordination' : 'Student workflow' ?></dd>
                                </div>
                            </dl>

                            <div class="admin-account-card__actions">
                                <a href="<?= e(url('/admin/comptes/' . $account['id'] . '/edit')) ?>">Edit</a>
                                <form method="post" action="<?= e(url('/admin/comptes/' . $account['id'] . '/delete')) ?>" class="inline-form">
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

    <aside class="admin-accounts__aside">
        <div class="admin-dashboard-card admin-dashboard-card--soft">
            <span class="eyebrow">Admin guidance</span>
            <h2>Keep account governance simple.</h2>
            <p class="meta">
                Use creation for new access, editing for corrections, and deletion only when the account should no longer remain active in the platform scope.
            </p>

            <div class="admin-dashboard-card__stack">
                <a class="button button--primary" href="<?= e(url('/admin/comptes/create')) ?>">Create account</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/admin')) ?>">Back to dashboard</a>
                <a class="button button--ghost" href="<?= e(url('/statistiques')) ?>">Open statistics</a>
            </div>
        </div>
    </aside>
</section>
