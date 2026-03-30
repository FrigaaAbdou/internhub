<?php

declare(strict_types=1);
?>
<section class="container student-profile-page">
    <div class="student-profile-page__hero">
        <div class="student-profile-page__copy">
            <span class="eyebrow">Student space</span>
            <h1>My profile</h1>
            <p class="lead">
                Update your personal information and password while keeping your role and promotion locked to the academic workflow.
            </p>
        </div>

        <aside class="student-profile-page__hero-card">
            <span class="eyebrow">Profile rules</span>
            <h2>What you can edit here</h2>
            <p class="meta">
                You can update your first name, last name, email, and optional password. Role and promotion remain read-only.
            </p>
        </aside>
    </div>
</section>

<section class="container student-profile-layout">
    <div class="student-profile-layout__main">
        <article class="student-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Editable information</span>
                    <h2>Keep your account up to date.</h2>
                </div>
            </div>

            <form method="post" action="<?= e(url('/dashboard/etudiant/profil')) ?>" class="stack-form student-profile-form">
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
                    <small class="field-hint">Use the address tied to your student access.</small>
                    <?php if (! empty($errors['email'])): ?>
                        <small class="field-error"><?= e($errors['email']) ?></small>
                    <?php endif; ?>
                </label>

                <div class="student-profile-form__locked">
                    <div class="section-heading section-heading--compact">
                        <div>
                            <span class="eyebrow">Locked information</span>
                            <h2>Managed by the program team</h2>
                        </div>
                    </div>

                    <div class="field-row">
                        <label class="field">
                            <span>Role</span>
                            <input type="text" value="Student" disabled>
                        </label>

                        <label class="field">
                            <span>Promotion</span>
                            <input type="text" value="<?= e((string) ($values['promotion_name'] ?? 'Not assigned')) ?>" disabled>
                        </label>
                    </div>
                </div>

                <div class="student-profile-form__security">
                    <div class="section-heading section-heading--compact">
                        <div>
                            <span class="eyebrow">Security</span>
                            <h2>Change your password</h2>
                        </div>
                    </div>

                    <label class="field">
                        <span>New password</span>
                        <input type="password" name="password" autocomplete="new-password">
                        <small class="field-hint">Leave this empty if you do not want to change your current password.</small>
                        <?php if (! empty($errors['password'])): ?>
                            <small class="field-error"><?= e($errors['password']) ?></small>
                        <?php endif; ?>
                    </label>
                </div>

                <div class="student-profile-form__actions">
                    <button type="submit" class="button button--primary">Save changes</button>
                    <a class="button button--ghost" href="<?= e(url('/dashboard/etudiant')) ?>">Back to dashboard</a>
                </div>
            </form>
        </article>
    </div>

    <aside class="student-profile-layout__aside">
        <div class="student-dashboard-panel student-dashboard-panel--soft">
            <span class="eyebrow">Useful reminder</span>
            <h2>Keep your details consistent.</h2>
            <p class="meta">
                A clean profile helps you apply faster. If your role or promotion needs to change, that update must be handled by a coordinator or administrator.
            </p>

            <div class="student-dashboard-panel__stack">
                <a class="button button--primary" href="<?= e(url('/dashboard/etudiant')) ?>">Back to dashboard</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/etudiant/candidatures')) ?>">Review applications</a>
                <a class="button button--ghost" href="<?= e(url('/offres')) ?>">Explore internships</a>
            </div>
        </div>
    </aside>
</section>
