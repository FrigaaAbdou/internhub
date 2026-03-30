<?php

declare(strict_types=1);
?>
<section class="container auth-shell">
    <div class="auth-card auth-card--wide">
        <p class="eyebrow">Pilote</p>
        <h1>Creer un compte etudiant</h1>

        <form method="post" action="<?= e(url('/dashboard/pilote/etudiants/create')) ?>" class="stack-form">
            <?= csrf_field() ?>

            <label class="field">
                <span>Prenom</span>
                <input type="text" name="first_name" value="<?= e((string) ($values['first_name'] ?? '')) ?>" required>
                <?php if (! empty($errors['first_name'])): ?>
                    <small class="field-error"><?= e($errors['first_name']) ?></small>
                <?php endif; ?>
            </label>

            <label class="field">
                <span>Nom</span>
                <input type="text" name="last_name" value="<?= e((string) ($values['last_name'] ?? '')) ?>" required>
                <?php if (! empty($errors['last_name'])): ?>
                    <small class="field-error"><?= e($errors['last_name']) ?></small>
                <?php endif; ?>
            </label>

            <label class="field">
                <span>Email</span>
                <input type="email" name="email" value="<?= e((string) ($values['email'] ?? '')) ?>" required>
                <?php if (! empty($errors['email'])): ?>
                    <small class="field-error"><?= e($errors['email']) ?></small>
                <?php endif; ?>
            </label>

            <label class="field">
                <span>Promotion</span>
                <input type="text" value="<?= e((string) ($values['promotion_id'] ?? '')) ?>" disabled>
            </label>

            <label class="field">
                <span>Mot de passe initial</span>
                <input type="password" name="password" required>
                <?php if (! empty($errors['password'])): ?>
                    <small class="field-error"><?= e($errors['password']) ?></small>
                <?php endif; ?>
            </label>

            <div class="detail-actions">
                <button type="submit" class="button button--primary">Creer le compte</button>
                <a class="button button--secondary" href="<?= e(url('/dashboard/pilote/etudiants')) ?>">Annuler</a>
            </div>
        </form>
    </div>
</section>
