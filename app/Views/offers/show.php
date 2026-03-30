<?php

declare(strict_types=1);

$formatPostedAgo = static function (?string $rawDate): string {
    if (! is_string($rawDate) || trim($rawDate) === '') {
        return 'Published recently';
    }

    $createdAt = date_create($rawDate);
    $now = new DateTimeImmutable();

    if (! $createdAt instanceof DateTimeInterface) {
        return 'Published recently';
    }

    $diff = $now->diff(DateTimeImmutable::createFromMutable($createdAt));

    if ($diff->days <= 0) {
        return 'Posted today';
    }

    if ($diff->days === 1) {
        return 'Posted 1 day ago';
    }

    if ($diff->days < 7) {
        return 'Posted ' . $diff->days . ' days ago';
    }

    $weeks = (int) floor($diff->days / 7);

    return 'Posted ' . $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
};

$buildTags = static function (array $offer): array {
    $tags = [];
    $title = strtolower((string) ($offer['title'] ?? ''));
    $description = strtolower((string) ($offer['description'] ?? ''));

    foreach ([
        'react' => 'React',
        'typescript' => 'TypeScript',
        'python' => 'Python',
        'sql' => 'SQL',
        'design' => 'Design',
        'analytics' => 'Analytics',
        'product' => 'Product',
        'data' => 'Data',
        'marketing' => 'Marketing',
        'figma' => 'Figma',
    ] as $needle => $label) {
        if (str_contains($title, $needle) || str_contains($description, $needle)) {
            $tags[] = $label;
        }
    }

    $tags[] = (string) ($offer['contract_type'] ?? '');
    $tags[] = (string) ($offer['location'] ?? '');

    $tags = array_values(array_unique(array_filter($tags, static fn (string $tag): bool => trim($tag) !== '')));

    return array_slice($tags, 0, 5);
};

$summary = trim((string) strtok((string) ($offer['description'] ?? ''), "\n"));
$summary = $summary !== '' ? $summary : 'A structured internship opportunity published through InternHub.';
$tags = $buildTags($offer);
$companyWebsite = trim((string) ($offer['company_website'] ?? ''));
$companyDescription = trim((string) ($offer['company_description'] ?? ''));
?>
<section class="container offer-detail-page">
    <div class="offer-detail-page__back">
        <a class="offer-detail-page__back-link" href="<?= e(url('/offres')) ?>">← Back to internships</a>
    </div>

    <div class="offer-detail-hero">
        <div class="offer-detail-hero__copy">
            <span class="eyebrow">Internship detail</span>
            <h1><?= e((string) $offer['title']) ?></h1>
            <p class="offer-detail-hero__lead"><?= e($summary) ?></p>

            <ul class="offer-detail-hero__meta">
                <li><?= e((string) $offer['company_name']) ?></li>
                <li><?= e((string) $offer['location']) ?></li>
                <li><?= e((string) $offer['contract_type']) ?></li>
                <li><?= e($formatPostedAgo((string) ($offer['created_at'] ?? ''))) ?></li>
            </ul>

            <?php if ($tags !== []): ?>
                <div class="offer-detail-hero__tags">
                    <?php foreach ($tags as $tag): ?>
                        <span><?= e($tag) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="offer-detail-hero__actions">
                <?php if ($isStudent): ?>
                    <a class="button button--primary" href="<?= e(url('/offres/' . $offer['id'] . '/postuler')) ?>">Apply now</a>
                    <?php if ($isWishlisted): ?>
                        <form action="<?= e(url('/dashboard/etudiant/wishlist/' . $offer['id'] . '/delete')) ?>" method="post" class="inline-form">
                            <?= csrf_field() ?>
                            <input type="hidden" name="redirect_to" value="<?= e('/offres/' . $offer['id']) ?>">
                            <button type="submit" class="button button--secondary">Remove from wish-list</button>
                        </form>
                    <?php else: ?>
                        <form action="<?= e(url('/offres/' . $offer['id'] . '/wishlist')) ?>" method="post" class="inline-form">
                            <?= csrf_field() ?>
                            <button type="submit" class="button button--secondary">Save to wish-list</button>
                        </form>
                    <?php endif; ?>
                <?php elseif ($isGuest): ?>
                    <a class="button button--primary" href="<?= e(url('/login')) ?>">Sign in to apply</a>
                <?php endif; ?>

                <a class="button button--ghost" href="<?= e(url('/entreprises/' . $offer['company_id'])) ?>">View company</a>

                <?php if ($managementPath !== null): ?>
                    <a class="button button--secondary" href="<?= e(url($managementPath . '/' . $offer['id'] . '/edit')) ?>">Edit offer</a>
                <?php endif; ?>
            </div>
        </div>

        <aside class="offer-detail-hero__aside">
            <div class="offer-detail-glance">
                <span class="eyebrow">At a glance</span>
                <h2>Key information</h2>
                <dl class="offer-detail-glance__list">
                    <div>
                        <dt>Company</dt>
                        <dd><?= e((string) $offer['company_name']) ?></dd>
                    </div>
                    <div>
                        <dt>Location</dt>
                        <dd><?= e((string) $offer['location']) ?></dd>
                    </div>
                    <div>
                        <dt>Contract</dt>
                        <dd><?= e((string) $offer['contract_type']) ?></dd>
                    </div>
                    <div>
                        <dt>Published</dt>
                        <dd><?= e($formatPostedAgo((string) ($offer['created_at'] ?? ''))) ?></dd>
                    </div>
                </dl>
                <p class="offer-detail-glance__note">
                    InternHub keeps the application path simple: understand the role, review the company, then take the right action.
                </p>
            </div>
        </aside>
    </div>
</section>

<section class="container offer-detail-layout">
    <div class="offer-detail-layout__main">
        <article class="offer-detail-section offer-detail-section--description">
            <span class="eyebrow">Role overview</span>
            <h2>What this internship covers</h2>
            <div class="offer-detail-copy">
                <?php foreach (preg_split('/\R+/', (string) $offer['description']) ?: [] as $paragraph): ?>
                    <?php $paragraph = trim((string) $paragraph); ?>
                    <?php if ($paragraph !== ''): ?>
                        <p><?= e($paragraph) ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </article>

        <article class="offer-detail-section">
            <span class="eyebrow">About the company</span>
            <div class="offer-company-card">
                <div class="offer-company-card__header">
                    <div>
                        <h2><?= e((string) $offer['company_name']) ?></h2>
                        <p class="meta"><?= e((string) ($offer['company_city'] ?? $offer['location'])) ?></p>
                    </div>
                    <a class="button button--ghost" href="<?= e(url('/entreprises/' . $offer['company_id'])) ?>">Company profile</a>
                </div>

                <p class="offer-company-card__copy">
                    <?= e($companyDescription !== '' ? $companyDescription : 'This company is part of the InternHub partner network and publishes opportunities through the platform.') ?>
                </p>

                <div class="offer-company-card__links">
                    <?php if ($companyWebsite !== ''): ?>
                        <a href="<?= e($companyWebsite) ?>" target="_blank" rel="noreferrer">Visit website</a>
                    <?php endif; ?>
                    <a href="<?= e(url('/entreprises/' . $offer['company_id'])) ?>">See full company detail</a>
                </div>
            </div>
        </article>

        <?php if ($relatedOffers !== []): ?>
            <article class="offer-detail-section">
                <div class="section-heading section-heading--compact">
                    <div>
                        <span class="eyebrow">More from this company</span>
                        <h2>Other opportunities you may want to review.</h2>
                    </div>
                </div>

                <div class="offer-detail-related">
                    <?php foreach ($relatedOffers as $relatedOffer): ?>
                        <article class="offer-card offer-card--compact">
                            <div class="offer-card__header">
                                <div>
                                    <h3><?= e((string) $relatedOffer['title']) ?></h3>
                                    <p class="meta"><?= e((string) $offer['company_name']) ?></p>
                                </div>
                                <span class="offer-card__flag">Open</span>
                            </div>

                            <ul class="offer-card__meta">
                                <li><?= e((string) $relatedOffer['location']) ?></li>
                                <li><?= e((string) $relatedOffer['contract_type']) ?></li>
                            </ul>

                            <p class="offer-card__description">
                                <?= e(mb_strimwidth((string) $relatedOffer['description'], 0, 120, '...')) ?>
                            </p>

                            <div class="offer-card__footer">
                                <span class="meta"><?= e($formatPostedAgo((string) ($relatedOffer['created_at'] ?? ''))) ?></span>
                                <a href="<?= e(url('/offres/' . $relatedOffer['id'])) ?>">View details →</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </article>
        <?php endif; ?>
    </div>

    <aside class="offer-detail-layout__aside">
        <div class="offer-detail-panel">
            <span class="eyebrow">Next step</span>
            <h2>Choose the right action.</h2>
            <p class="meta">This page is designed to let you decide quickly without losing context.</p>

            <div class="offer-detail-panel__actions">
                <a class="button button--ghost" href="<?= e(url('/offres')) ?>">Back to listing</a>
                <a class="button button--secondary" href="<?= e(url('/entreprises/' . $offer['company_id'])) ?>">Open company page</a>
                <?php if ($isStudent): ?>
                    <a class="button button--primary" href="<?= e(url('/offres/' . $offer['id'] . '/postuler')) ?>">Apply from here</a>
                <?php elseif ($isGuest): ?>
                    <a class="button button--primary" href="<?= e(url('/login')) ?>">Sign in to continue</a>
                <?php endif; ?>
            </div>
        </div>
    </aside>
</section>
