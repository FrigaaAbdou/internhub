<?php

declare(strict_types=1);
?>
<section class="container pilot-student-edit-page">
    <div class="pilot-student-edit-page__hero">
        <div class="pilot-student-edit-page__copy">
            <span class="eyebrow">Pilot space</span>
            <h1>Edit student access</h1>
            <p class="lead">
                Update the student's identity and access email while keeping the academic assignment locked to your promotion.
            </p>

            <ul class="pilot-student-edit-page__meta">
                <li><?= e(trim(((string) ($values['first_name'] ?? '')) . ' ' . ((string) ($values['last_name'] ?? '')))) ?></li>
                <li><?= e((string) ($values['email'] ?? '')) ?></li>
                <li>Promotion <?= e((string) ($values['promotion_id'] ?? '')) ?></li>
            </ul>
        </div>

        <aside class="pilot-student-edit-page__hero-card">
            <span class="eyebrow">Editing rules</span>
            <h2>What can be updated here</h2>
            <p class="meta">
                First name, last name, email, and optional password can be updated. Role and promotion stay fixed to preserve the academic scope.
            </p>
        </aside>
    </div>
</section>

<section class="container pilot-student-edit-layout">
    <div class="pilot-student-edit-layout__main">
        <article class="pilot-student-edit-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Editable access</span>
                    <h2>Keep the student's account accurate.</h2>
                </div>
            </div>

            <form method="post" action="<?= e(url('/dashboard/pilote/etudiants/' . $values['id'] . '/edit')) ?>" class="stack-form pilot-student-edit-form">
                <?= csrf_field() ?>

                <div class="field-row">
                    <label class="field">
                        <span>First name</span>
                        <input type="text" name="first_name" value="<?= e((string) ($values['first_name'] ?? '')) ?>" required>
                        <?php if (! empty($errors['first_name'])): ?>
                            <small class="field-error"><?= e($errors['first_name']) ?></small>
                        <?php endif; ?>
                    </label>

                    <label class="field">
                        <span>Last name</span>
                        <input type="text" name="last_name" value="<?= e((string) ($values['last_name'] ?? '')) ?>" required>
                        <?php if (! empty($errors['last_name'])): ?>
                            <small class="field-error"><?= e($errors['last_name']) ?></small>
                        <?php endif; ?>
                    </label>
                </div>

                <label class="field">
                    <span>Email address</span>
                    <input type="email" name="email" value="<?= e((string) ($values['email'] ?? '')) ?>" required>
                    <small class="field-hint">Use the address the student will use to sign in to InternHub.</small>
                    <?php if (! empty($errors['email'])): ?>
                        <small class="field-error"><?= e($errors['email']) ?></small>
                    <?php endif; ?>
                </label>

                <div class="pilot-student-edit-form__locked">
                    <div class="section-heading section-heading--compact">
                        <div>
                            <span class="eyebrow">Locked scope</span>
                            <h2>Managed by the academic structure</h2>
                        </div>
                    </div>

                    <div class="field-row">
                        <label class="field">
                            <span>Role</span>
                            <input type="text" value="Student" disabled>
                        </label>

                        <label class="field">
                            <span>Promotion</span>
                            <input type="text" value="<?= e((string) ($values['promotion_id'] ?? '')) ?>" disabled>
                        </label>
                    </div>
                </div>

                <div class="pilot-student-edit-form__security">
                    <div class="section-heading section-heading--compact">
                        <div>
                            <span class="eyebrow">Security</span>
                            <h2>Reset the password if needed</h2>
                        </div>
                    </div>

                    <label class="field">
                        <span>New password</span>
                        <input type="password" name="password" autocomplete="new-password">
                        <small class="field-hint">Leave this empty to keep the current password unchanged.</small>
                        <?php if (! empty($errors['password'])): ?>
                            <small class="field-error"><?= e($errors['password']) ?></small>
                        <?php endif; ?>
                    </label>
                </div>

                <div class="pilot-student-edit-form__actions">
                    <button type="submit" class="button button--primary">Save changes</button>
                    <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants/' . $values['id'])) ?>">Back to student profile</a>
                </div>
            </form>
        </article>
    </div>

    <aside class="pilot-student-edit-layout__aside">
        <div class="pilot-student-edit-card pilot-student-edit-card--soft">
            <span class="eyebrow">Pilot guidance</span>
            <h2>Keep access clear and current.</h2>
            <p class="meta">
                Use this page to correct identity details or rotate access credentials. Promotion assignment must stay aligned with your supervision scope.
            </p>

            <div class="pilot-student-edit-card__stack">
                <a class="button button--primary" href="<?= e(url('/dashboard/pilote/etudiants/' . $values['id'])) ?>">Open student profile</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants/' . $values['id'] . '/candidatures')) ?>">Review applications</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/pilote/etudiants')) ?>">Back to student roster</a>
            </div>
        </div>
    </aside>
</section>
