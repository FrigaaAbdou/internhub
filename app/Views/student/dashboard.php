<?php

declare(strict_types=1);

$statusLabel = static function (?string $status): string {
    return match ((string) $status) {
        'envoyee' => 'Submitted',
        'en_cours' => 'In review',
        'acceptee' => 'Accepted',
        'refusee' => 'Declined',
        default => 'Updated',
    };
};

$formatDate = static function (?string $rawDate): string {
    if (! is_string($rawDate) || trim($rawDate) === '') {
        return 'Recent update';
    }

    $date = date_create($rawDate);

    return $date instanceof DateTimeInterface ? $date->format('d M Y') : 'Recent update';
};

$firstName = (string) (($student['first_name'] ?? 'Student'));
$quickLinks = [
    [
        'title' => 'Explore internships',
        'copy' => 'Browse the latest offers and move directly into the application flow.',
        'href' => '/offres',
        'variant' => 'primary',
    ],
    [
        'title' => 'My profile',
        'copy' => 'Keep your personal information up to date before applying.',
        'href' => '/dashboard/etudiant/profil',
        'variant' => 'secondary',
    ],
    [
        'title' => 'My applications',
        'copy' => 'Review submitted applications and download your latest CV files.',
        'href' => '/dashboard/etudiant/candidatures',
        'variant' => 'secondary',
    ],
    [
        'title' => 'Wish-list',
        'copy' => 'Return to the offers you saved for later comparison.',
        'href' => '/dashboard/etudiant/wishlist',
        'variant' => 'secondary',
    ],
    [
        'title' => 'Companies',
        'copy' => 'Explore the company directory behind the published offers.',
        'href' => '/entreprises',
        'variant' => 'secondary',
    ],
    [
        'title' => 'Statistics',
        'copy' => 'See public platform insights and the internship network overview.',
        'href' => '/statistiques',
        'variant' => 'secondary',
    ],
];
?>
<section class="container student-dashboard">
    <div class="student-dashboard__hero">
        <div class="student-dashboard__copy">
            <span class="eyebrow">Student space</span>
            <h1>Student dashboard</h1>
            <p class="lead">
                Welcome back, <?= e($firstName) ?>. Track your applications, return to your saved offers, and move quickly to the next useful action.
            </p>
        </div>

        <aside class="student-dashboard__hero-card">
            <span class="eyebrow">Overview</span>
            <h2>Your internship workspace</h2>
            <p class="meta">
                This area is designed to keep your progress readable: where you stand, what you can do now, and where to go next.
            </p>
        </aside>
    </div>

    <div class="student-dashboard__stats">
        <article class="student-stat-card">
            <span class="student-stat-card__label">Applications</span>
            <strong><?= e((string) $applicationCount) ?></strong>
            <p>Submitted opportunities currently linked to your account.</p>
        </article>
        <article class="student-stat-card">
            <span class="student-stat-card__label">Published offers</span>
            <strong><?= e((string) $publishedOfferCount) ?></strong>
            <p>Live internships available to browse through the platform.</p>
        </article>
        <article class="student-stat-card">
            <span class="student-stat-card__label">Companies</span>
            <strong><?= e((string) $companyCount) ?></strong>
            <p>Partner organizations already structured in InternHub.</p>
        </article>
        <article class="student-stat-card">
            <span class="student-stat-card__label">Wish-list</span>
            <strong><?= e((string) $wishlistCount) ?></strong>
            <p>Saved opportunities you can return to before applying.</p>
        </article>
    </div>
</section>

<section class="container student-dashboard-sections">
    <div class="student-dashboard-sections__main">
        <article class="student-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Quick actions</span>
                    <h2>Go directly to what matters now.</h2>
                </div>
            </div>

            <div class="student-quick-grid">
                <?php foreach ($quickLinks as $link): ?>
                    <a class="student-quick-card<?= $link['variant'] === 'primary' ? ' student-quick-card--primary' : '' ?>" href="<?= e(url($link['href'])) ?>">
                        <h3><?= e($link['title']) ?></h3>
                        <p><?= e($link['copy']) ?></p>
                        <span>Open →</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </article>

        <article class="student-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Recent applications</span>
                    <h2>Latest activity from your application flow.</h2>
                </div>
            </div>

            <?php if ($recentApplications === []): ?>
                <div class="panel empty-state">
                    <h3>No applications yet</h3>
                    <p>Start by exploring the published internships, then come back here to follow your submissions.</p>
                    <a class="button button--primary" href="<?= e(url('/offres')) ?>">Explore internships</a>
                </div>
            <?php else: ?>
                <div class="student-activity-list">
                    <?php foreach ($recentApplications as $application): ?>
                        <article class="student-activity-card">
                            <div class="student-activity-card__header">
                                <div>
                                    <h3><?= e((string) $application['offer_title']) ?></h3>
                                    <p class="meta"><?= e((string) $application['company_name']) ?></p>
                                </div>
                                <span class="student-status-pill student-status-pill--<?= e((string) $application['status']) ?>">
                                    <?= e($statusLabel((string) $application['status'])) ?>
                                </span>
                            </div>

                            <div class="student-activity-card__meta">
                                <span><?= e($formatDate((string) $application['created_at'])) ?></span>
                            </div>

                            <div class="student-activity-card__actions">
                                <a href="<?= e(url('/dashboard/etudiant/candidatures/' . $application['id'])) ?>">View detail</a>
                                <?php if (! empty($application['cv_path'])): ?>
                                    <a href="<?= e(url('/dashboard/etudiant/candidatures/' . $application['id'] . '/cv')) ?>">Download CV</a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>
    </div>

    <aside class="student-dashboard-sections__aside">
        <div class="student-dashboard-panel student-dashboard-panel--soft">
            <span class="eyebrow">Keep momentum</span>
            <h2>Build a clear next step.</h2>
            <p class="meta">
                The dashboard should help you move from browsing to action without feeling like a back-office tool.
            </p>

            <div class="student-dashboard-panel__stack">
                <a class="button button--primary" href="<?= e(url('/offres')) ?>">Browse published offers</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/etudiant/wishlist')) ?>">Open my wish-list</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/etudiant/candidatures')) ?>">Review my applications</a>
            </div>
        </div>
    </aside>
</section>
