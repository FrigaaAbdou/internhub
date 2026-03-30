<?php

declare(strict_types=1);

$website = trim((string) ($company['website'] ?? ''));
$offers = is_array($company['offers'] ?? null) ? $company['offers'] : [];
$offerCount = count($offers);
$description = trim((string) ($company['description'] ?? ''));
?>
<section class="container company-detail-page">
    <div class="company-detail-page__back">
        <a class="company-detail-page__back-link" href="<?= e(url('/entreprises')) ?>">← Back to companies</a>
    </div>

    <div class="company-detail-hero">
        <div class="company-detail-hero__copy">
            <span class="eyebrow">Company detail</span>
            <h1><?= e((string) $company['name']) ?></h1>
            <p class="company-detail-hero__lead">
                Browse this organization’s profile and review the internship opportunities already available through InternHub.
            </p>

            <ul class="company-detail-hero__meta">
                <li><?= e((string) $company['industry']) ?></li>
                <li><?= e((string) $company['city']) ?></li>
                <li><?= $offerCount ?> active offer<?= $offerCount > 1 ? 's' : '' ?></li>
            </ul>

            <div class="company-detail-hero__actions">
                <a class="button button--ghost" href="<?= e(url('/entreprises')) ?>">Back to directory</a>
                <?php if ($website !== ''): ?>
                    <a class="button button--secondary" href="<?= e($website) ?>" target="_blank" rel="noreferrer">Visit website</a>
                <?php endif; ?>
                <?php if ($managementPath !== null): ?>
                    <a class="button button--primary" href="<?= e(url($managementPath . '/' . $company['id'] . '/edit')) ?>">Edit company</a>
                <?php endif; ?>
            </div>
        </div>

        <aside class="company-detail-hero__aside">
            <div class="company-detail-glance">
                <span class="eyebrow">At a glance</span>
                <h2>Company snapshot</h2>
                <dl class="company-detail-glance__list">
                    <div>
                        <dt>Sector</dt>
                        <dd><?= e((string) $company['industry']) ?></dd>
                    </div>
                    <div>
                        <dt>City</dt>
                        <dd><?= e((string) $company['city']) ?></dd>
                    </div>
                    <div>
                        <dt>Active offers</dt>
                        <dd><?= $offerCount ?></dd>
                    </div>
                    <div>
                        <dt>Website</dt>
                        <dd><?= $website !== '' ? 'Available' : 'Not provided' ?></dd>
                    </div>
                </dl>
                <p class="company-detail-glance__note">
                    This page keeps the company profile simple and directly connected to the available internships.
                </p>
            </div>
        </aside>
    </div>
</section>

<section class="container company-detail-layout">
    <div class="company-detail-layout__main">
        <article class="company-detail-section">
            <span class="eyebrow">Presentation</span>
            <h2>About <?= e((string) $company['name']) ?></h2>
            <div class="company-detail-copy">
                <?php foreach (preg_split('/\R+/', $description) ?: [] as $paragraph): ?>
                    <?php $paragraph = trim((string) $paragraph); ?>
                    <?php if ($paragraph !== ''): ?>
                        <p><?= e($paragraph) ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </article>

        <article class="company-detail-section">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Published internships</span>
                    <h2>Current opportunities from this company.</h2>
                    <p class="meta">Use these links to move directly from company context to role detail.</p>
                </div>
            </div>

            <?php if ($offers === []): ?>
                <div class="panel empty-state">
                    <h3>No active internships right now</h3>
                    <p>This company is listed on InternHub, but it does not currently have published offers.</p>
                </div>
            <?php else: ?>
                <div class="company-detail-offers">
                    <?php foreach ($offers as $offer): ?>
                        <article class="offer-card offer-card--compact">
                            <div class="offer-card__header">
                                <div>
                                    <h3><?= e((string) $offer['title']) ?></h3>
                                    <p class="meta"><?= e((string) $company['name']) ?></p>
                                </div>
                                <span class="offer-card__flag">Open</span>
                            </div>

                            <ul class="offer-card__meta">
                                <li><?= e((string) $offer['location']) ?></li>
                                <li><?= e((string) $offer['contract_type']) ?></li>
                            </ul>

                            <div class="offer-card__footer">
                                <span class="meta">Published opportunity</span>
                                <a href="<?= e(url('/offres/' . $offer['id'])) ?>">View offer →</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>
    </div>

    <aside class="company-detail-layout__aside">
        <div class="company-detail-panel">
            <span class="eyebrow">Useful links</span>
            <h2>Navigate without losing context.</h2>
            <p class="meta">
                From here, users should be able to go back to the directory, open the company website, or continue into one of the published offers.
            </p>

            <div class="company-detail-panel__actions">
                <a class="button button--ghost" href="<?= e(url('/entreprises')) ?>">Back to directory</a>
                <?php if ($website !== ''): ?>
                    <a class="button button--secondary" href="<?= e($website) ?>" target="_blank" rel="noreferrer">Open website</a>
                <?php endif; ?>
                <?php if ($offers !== []): ?>
                    <a class="button button--primary" href="<?= e(url('/offres/' . $offers[0]['id'])) ?>">See first opportunity</a>
                <?php endif; ?>
            </div>
        </div>
    </aside>
</section>
