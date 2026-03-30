<?php

declare(strict_types=1);
?>
<section class="auth-page">
    <div class="auth-page__shell">
        <div class="auth-page__panel">
            <a class="brand auth-brand" href="<?= e(url('/')) ?>">
                <img class="brand__logo" src="<?= e(asset('/assets/mini-logo.png')) ?>" alt="" aria-hidden="true">
                <span>InternHub</span>
            </a>

            <div class="auth-page__intro">
                <p class="eyebrow">Secure access</p>
                <h1>Welcome back</h1>
                <p class="lead">Sign in to access your internships, applications, and dashboard.</p>
            </div>

            <?php if (! empty($errors['credentials'])): ?>
                <div class="flash flash--error" role="alert"><?= e($errors['credentials']) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= e(url('/login')) ?>" class="stack-form auth-form">
                <?= csrf_field() ?>

                <label class="field">
                    <span>Email address</span>
                    <input
                        type="email"
                        name="email"
                        value="<?= e((string) $email) ?>"
                        required
                        autocomplete="email"
                        placeholder="user@example.com"
                    >
                    <?php if (! empty($errors['email'])): ?>
                        <small class="field-error"><?= e($errors['email']) ?></small>
                    <?php endif; ?>
                </label>

                <label class="field">
                    <span>Password</span>
                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    >
                    <?php if (! empty($errors['password'])): ?>
                        <small class="field-error"><?= e($errors['password']) ?></small>
                    <?php endif; ?>
                </label>

                <p class="auth-form__hint">Student, coordinator, and administrator access only.</p>

                <button type="submit" class="button button--primary auth-submit">Sign in</button>
            </form>

            <p class="auth-page__footnote">Secure access. Your data is protected.</p>
        </div>

        <div class="auth-page__media" aria-hidden="true">
            <div class="auth-page__media-shell">
                <img
                    class="auth-page__image"
                    src="<?= e(asset('/assets/login-img.png')) ?>"
                    alt=""
                >
            </div>
        </div>
    </div>
</section>
