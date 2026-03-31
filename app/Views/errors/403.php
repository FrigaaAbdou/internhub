<?php

declare(strict_types=1);

use App\Core\Auth;

$homePath = '/';
$supportPath = Auth::check()
    ? match (Auth::role()) {
        'etudiant' => '/dashboard/etudiant',
        'pilote' => '/dashboard/pilote',
        'administrateur' => '/dashboard/admin',
        default => '/',
    }
    : '/login';
?>
<section class="container support-error-page support-error-page--forbidden">
    <div class="support-error-page__hero">
        <div class="support-error-page__copy">
            <span class="eyebrow">Error <?= e((string) ($statusCode ?? 403)) ?></span>
            <h1>Access denied</h1>
            <p class="lead">
                <?= e($message ?? 'You do not have the required permissions to access this resource.') ?>
            </p>
        </div>

        <aside class="support-error-page__hero-card">
            <span class="eyebrow">What happened</span>
            <h2>This area is outside your current scope.</h2>
            <p class="meta">
                The page exists, but your current access level does not allow you to open it. Use the links below to return to a valid area of InternHub.
            </p>
        </aside>
    </div>
</section>

<section class="container support-error-page__content">
    <div class="support-error-page__main">
        <article class="support-error-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Next step</span>
                    <h2>Return to an authorized page.</h2>
                </div>
            </div>

            <p class="meta">
                If you expected to access this resource, verify that you are using the right account or role. Otherwise, go back to a public page or your current dashboard.
            </p>

            <div class="support-error-card__stack">
                <a class="button button--primary" href="<?= e(url($supportPath)) ?>">
                    <?= Auth::check() ? 'Go to my dashboard' : 'Go to sign in' ?>
                </a>
                <a class="button button--ghost" href="<?= e(url('/offres')) ?>">Explore internships</a>
                <a class="button button--ghost" href="<?= e(url($homePath)) ?>">Back to homepage</a>
            </div>
        </article>
    </div>

    <aside class="support-error-page__aside">
        <div class="support-error-card support-error-card--soft">
            <span class="eyebrow">Support context</span>
            <h2>Protected routes stay role-based.</h2>
            <p class="meta">
                InternHub separates public pages, student space, pilot supervision, and administrator governance. This protection prevents users from reaching actions outside their role.
            </p>
        </div>
    </aside>
</section>
