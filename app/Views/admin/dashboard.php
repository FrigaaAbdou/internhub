<?php

declare(strict_types=1);
?>
<section class="container admin-dashboard-page">
    <div class="admin-dashboard__hero">
        <div class="admin-dashboard__copy">
            <span class="eyebrow">Admin space</span>
            <h1>Dashboard admin</h1>
            <p class="lead">
                Monitor the platform at a glance and move directly into governance actions for accounts, companies, offers, and statistics.
            </p>
        </div>

        <aside class="admin-dashboard__hero-card">
            <span class="eyebrow">System role</span>
            <h2>Global platform oversight</h2>
            <p class="meta">
                This area is designed for governance: supervise access, keep core datasets reliable, and navigate quickly to the modules that need action.
            </p>
        </aside>
    </div>
</section>

<section class="container admin-dashboard__content">
    <div class="admin-dashboard__main">
        <article class="admin-dashboard-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Platform volumes</span>
                    <h2>Key indicators</h2>
                </div>
            </div>

            <div class="admin-dashboard__stats">
                <article class="admin-stat-card">
                    <span class="eyebrow">Accounts</span>
                    <strong><?= e((string) $pilotCount) ?></strong>
                    <p class="meta">Pilot accounts currently active on the platform.</p>
                </article>

                <article class="admin-stat-card">
                    <span class="eyebrow">Students</span>
                    <strong><?= e((string) $studentCount) ?></strong>
                    <p class="meta">Student accounts available for internship tracking.</p>
                </article>

                <article class="admin-stat-card">
                    <span class="eyebrow">Companies</span>
                    <strong><?= e((string) $companyCount) ?></strong>
                    <p class="meta">Partner companies currently listed in InternHub.</p>
                </article>

                <article class="admin-stat-card">
                    <span class="eyebrow">Published offers</span>
                    <strong><?= e((string) $publishedOfferCount) ?></strong>
                    <p class="meta">Offers visible in the public internship catalog.</p>
                </article>
            </div>
        </article>

        <article class="admin-dashboard-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Actions rapides</span>
                    <h2>Move straight to the right module.</h2>
                </div>
            </div>

            <div class="admin-quick-grid">
                <a class="admin-quick-card" href="<?= e(url('/admin/comptes')) ?>">
                    <h3>Manage accounts</h3>
                    <p>Review, create, edit, and remove pilot or student access.</p>
                </a>

                <a class="admin-quick-card" href="<?= e(url('/admin/entreprises')) ?>">
                    <h3>Manage companies</h3>
                    <p>Keep the company directory clean, consistent, and useful.</p>
                </a>

                <a class="admin-quick-card" href="<?= e(url('/admin/offres')) ?>">
                    <h3>Manage offers</h3>
                    <p>Control the publication pipeline and the internship catalog.</p>
                </a>

                <a class="admin-quick-card" href="<?= e(url('/statistiques')) ?>">
                    <h3>Review statistics</h3>
                    <p>Open the public aggregates and validate overall platform activity.</p>
                </a>
            </div>
        </article>
    </div>

    <aside class="admin-dashboard__aside">
        <div class="admin-dashboard-card admin-dashboard-card--soft">
            <span class="eyebrow">Admin focus</span>
            <h2>What to check first</h2>
            <p class="meta">
                Prioritize account integrity, then verify company and offer consistency. This keeps the public experience and role-based access stable.
            </p>

            <div class="admin-dashboard-card__stack">
                <a class="button button--primary" href="<?= e(url('/admin/comptes')) ?>">Open accounts</a>
                <a class="button button--ghost" href="<?= e(url('/admin/entreprises')) ?>">Open companies</a>
                <a class="button button--ghost" href="<?= e(url('/admin/offres')) ?>">Open offers</a>
                <a class="button button--ghost" href="<?= e(url('/statistiques')) ?>">View statistics</a>
            </div>
        </div>
    </aside>
</section>
