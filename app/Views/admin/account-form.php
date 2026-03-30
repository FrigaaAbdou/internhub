<?php

declare(strict_types=1);

$isEdit = $mode === 'edit';
$pageEyebrow = $isEdit ? 'Account edition' : 'Account creation';
$heroTitle = $isEdit ? 'Edit account' : 'Create account';
$heroDescription = $isEdit
    ? 'Update role, promotion, and access information while keeping the account aligned with the platform governance rules.'
    : 'Create a new pilot or student account with a clear role, a valid promotion, and secure initial access.';
$passwordLabel = $isEdit ? 'New password' : 'Initial password';
$passwordHint = $isEdit
    ? 'Leave this empty to keep the current password unchanged.'
    : 'Set a first password with at least 8 characters.';
?>
<section class="container admin-account-form-page">
    <div class="admin-account-form__hero">
        <div class="admin-account-form__copy">
            <span class="eyebrow">Admin space</span>
            <h1><?= e($heroTitle) ?></h1>
            <p class="lead">
                <?= e($heroDescription) ?>
            </p>
        </div>

        <aside class="admin-account-form__hero-card">
            <span class="eyebrow"><?= e($pageEyebrow) ?></span>
            <h2><?= $isEdit ? 'Adjust access without breaking governance' : 'Open access with a structured setup' ?></h2>
            <p class="meta">
                Role and promotion define how the account behaves in the product. Keep both coherent with the real academic organization.
            </p>
        </aside>
    </div>
</section>

<section class="container admin-account-form__content">
    <div class="admin-account-form__main">
        <article class="admin-dashboard-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Account fields</span>
                    <h2><?= $isEdit ? 'Update access information.' : 'Configure the new account.' ?></h2>
                </div>
            </div>

            <form method="post" action="<?= e(url($formAction)) ?>" class="stack-form admin-account-form">
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
                    <small class="field-hint">This address will be used as the sign-in identifier.</small>
                    <?php if (! empty($errors['email'])): ?>
                        <small class="field-error"><?= e($errors['email']) ?></small>
                    <?php endif; ?>
                </label>

                <div class="field-row">
                    <label class="field">
                        <span>Role</span>
                        <select name="role" required>
                            <option value="etudiant" <?= ($values['role'] ?? '') === 'etudiant' ? 'selected' : '' ?>>Etudiant</option>
                            <option value="pilote" <?= ($values['role'] ?? '') === 'pilote' ? 'selected' : '' ?>>Pilote</option>
                        </select>
                        <small class="field-hint">Choose the account type that matches the real workflow scope.</small>
                        <?php if (! empty($errors['role'])): ?>
                            <small class="field-error"><?= e($errors['role']) ?></small>
                        <?php endif; ?>
                    </label>

                    <label class="field">
                        <span>Promotion</span>
                        <select name="promotion_id" required>
                            <option value="">Choisir une promotion</option>
                            <?php foreach ($promotions as $promotion): ?>
                                <option value="<?= e((string) $promotion['id']) ?>" <?= (string) ($values['promotion_id'] ?? '') === (string) $promotion['id'] ? 'selected' : '' ?>>
                                    <?= e((string) $promotion['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="field-hint">Every manageable account must stay attached to a valid promotion.</small>
                        <?php if (! empty($errors['promotion_id'])): ?>
                            <small class="field-error"><?= e($errors['promotion_id']) ?></small>
                        <?php endif; ?>
                    </label>
                </div>

                <div class="admin-account-form__security">
                    <div class="section-heading section-heading--compact">
                        <div>
                            <span class="eyebrow">Security</span>
                            <h2><?= $isEdit ? 'Password reset' : 'Initial credentials' ?></h2>
                        </div>
                    </div>

                    <label class="field">
                        <span><?= e($passwordLabel) ?></span>
                        <input type="password" name="password" autocomplete="new-password" <?= $isEdit ? '' : 'required' ?>>
                        <small class="field-hint"><?= e($passwordHint) ?></small>
                        <?php if (! empty($errors['password'])): ?>
                            <small class="field-error"><?= e($errors['password']) ?></small>
                        <?php endif; ?>
                    </label>
                </div>

                <div class="admin-account-form__actions">
                    <button type="submit" class="button button--primary"><?= $isEdit ? 'Save changes' : 'Create account' ?></button>
                    <a class="button button--ghost" href="<?= e(url('/admin/comptes')) ?>">Back to accounts</a>
                </div>
            </form>
        </article>
    </div>

    <aside class="admin-account-form__aside">
        <div class="admin-dashboard-card admin-dashboard-card--soft">
            <span class="eyebrow">Admin guidance</span>
            <h2><?= $isEdit ? 'Keep role assignment consistent.' : 'Create with the right scope from the start.' ?></h2>
            <p class="meta">
                Pilot accounts supervise students within a promotion. Student accounts consume the internship workflow. The promotion link must remain reliable.
            </p>

            <div class="admin-dashboard-card__stack">
                <a class="button button--primary" href="<?= e(url('/admin/comptes')) ?>">Open accounts</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/admin')) ?>">Back to dashboard</a>
                <a class="button button--ghost" href="<?= e(url('/statistiques')) ?>">Open statistics</a>
            </div>
        </div>
    </aside>
</section>
