<?php

declare(strict_types=1);

$formatDate = static function (?string $rawDate): string {
    if (! is_string($rawDate) || trim($rawDate) === '') {
        return 'Recent save';
    }

    $date = date_create($rawDate);

    return $date instanceof DateTimeInterface ? $date->format('d M Y') : 'Recent save';
};
?>
<section class="container student-wishlist-page">
    <div class="student-wishlist-page__hero">
        <div class="student-wishlist-page__copy">
            <span class="eyebrow">Student space</span>
            <h1>My wish-list</h1>
            <p class="lead">
                Keep internship opportunities aside so you can return to them later, compare them, and decide when to apply.
            </p>
        </div>

        <aside class="student-wishlist-page__hero-card">
            <span class="eyebrow">Saved offers</span>
            <h2><?= count($items) ?> offer<?= count($items) > 1 ? 's' : '' ?> currently saved</h2>
            <p class="meta">
                This page is meant to help you pick up your search where you left it, without adding extra workflow complexity.
            </p>
        </aside>
    </div>
</section>

<section class="container student-wishlist-layout">
    <div class="student-wishlist-layout__main">
        <article class="student-dashboard-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Wish-list</span>
                    <h2>Saved opportunities you can revisit.</h2>
                </div>
                <a class="button button--secondary" href="<?= e(url('/offres')) ?>">Explore internships</a>
            </div>

            <?php if ($items === []): ?>
                <div class="panel empty-state">
                    <h3>Your wish-list is empty</h3>
                    <p>Explore the internship directory and save the offers you want to compare or revisit later.</p>
                    <a class="button button--primary" href="<?= e(url('/offres')) ?>">Browse internships</a>
                </div>
            <?php else: ?>
                <div class="student-wishlist-list">
                    <?php foreach ($items as $item): ?>
                        <article class="student-wishlist-card">
                            <div class="student-wishlist-card__header">
                                <div>
                                    <h3><?= e((string) $item['title']) ?></h3>
                                    <p class="meta"><?= e((string) $item['company_name']) ?></p>
                                </div>
                                <span class="student-wishlist-card__flag"><?= e((string) $item['contract_type']) ?></span>
                            </div>

                            <div class="student-wishlist-card__meta">
                                <span><?= e((string) $item['location']) ?></span>
                                <span>Saved on <?= e($formatDate((string) $item['created_at'])) ?></span>
                            </div>

                            <div class="student-wishlist-card__actions">
                                <a href="<?= e(url('/offres/' . $item['offer_id'])) ?>">View internship</a>
                                <form method="post" action="<?= e(url('/dashboard/etudiant/wishlist/' . $item['offer_id'] . '/delete')) ?>" class="inline-form">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="button-link danger-link">Remove</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>
    </div>

    <aside class="student-wishlist-layout__aside">
        <div class="student-dashboard-panel student-dashboard-panel--soft">
            <span class="eyebrow">Next step</span>
            <h2>Turn saved offers into action.</h2>
            <p class="meta">
                Use your wish-list to narrow down interesting opportunities, then open the offer detail page when you are ready to apply.
            </p>

            <div class="student-dashboard-panel__stack">
                <a class="button button--primary" href="<?= e(url('/offres')) ?>">Explore internships</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/etudiant/candidatures')) ?>">Review applications</a>
                <a class="button button--ghost" href="<?= e(url('/dashboard/etudiant')) ?>">Back to dashboard</a>
            </div>
        </div>
    </aside>
</section>
