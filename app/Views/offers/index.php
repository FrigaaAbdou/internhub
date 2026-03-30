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

    foreach ([
        'data' => 'Data',
        'product' => 'Product',
        'consultant' => 'Consulting',
        'developpement' => 'Development',
        'digital' => 'Digital',
        'analyst' => 'Analytics',
    ] as $needle => $label) {
        if (str_contains($title, $needle)) {
            $tags[] = $label;
        }
    }

    $tags[] = (string) ($offer['contract_type'] ?? '');
    $tags[] = (string) ($offer['location'] ?? '');

    $tags = array_values(array_unique(array_filter($tags, static fn (string $tag): bool => trim($tag) !== '')));

    return array_slice($tags, 0, 3);
};

$locations = array_slice((array) ($filterOptions['locations'] ?? []), 0, 6);
$contractTypes = array_slice((array) ($filterOptions['contractTypes'] ?? []), 0, 4);
?>
<section class="container offers-showcase">
    <div class="offers-showcase__hero">
        <div class="offers-showcase__copy">
            <span class="eyebrow">Explore internships</span>
            <h1>Explore internship programs</h1>
            <p class="lead">
                Browse opportunities from partner companies and find internships that match your skills and goals.
            </p>
            <ul class="offers-showcase__stats">
                <li><span class="stat-dot stat-dot--green"></span><strong><?= $total ?>+</strong> active internships</li>
                <li><span class="stat-dot stat-dot--violet"></span><strong><?= $companyCount ?>+</strong> partner companies</li>
                <li><span class="stat-dot stat-dot--blue"></span><strong>3</strong> user roles in one workflow</li>
            </ul>
        </div>
        <div class="offers-showcase__media" aria-hidden="true">
            <img class="offers-showcase__image" src="<?= e(asset('/assets/explore.png')) ?>" alt="">
        </div>
    </div>

    <form method="get" class="offers-filters">
        <div class="offers-filters__search">
            <span class="offers-filters__icon" aria-hidden="true">⌕</span>
            <input
                type="search"
                name="q"
                value="<?= e((string) ($filters['q'] ?? '')) ?>"
                placeholder="Search by role, skill, or company..."
                aria-label="Search internships"
            >
        </div>

        <div class="offers-filters__controls">
            <span class="offers-filters__label">Filters :</span>

            <label class="sr-only" for="offers-location">Location</label>
            <select id="offers-location" name="location">
                <option value="">All locations</option>
                <?php foreach (($filterOptions['locations'] ?? []) as $location): ?>
                    <option value="<?= e((string) $location) ?>" <?= (string) ($filters['location'] ?? '') === (string) $location ? 'selected' : '' ?>>
                        <?= e((string) $location) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="sr-only" for="offers-contract">Contract type</label>
            <select id="offers-contract" name="contract_type">
                <option value="">All compensation</option>
                <?php foreach (($filterOptions['contractTypes'] ?? []) as $contractType): ?>
                    <option value="<?= e((string) $contractType) ?>" <?= (string) ($filters['contract_type'] ?? '') === (string) $contractType ? 'selected' : '' ?>>
                        <?= e((string) $contractType) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="button button--primary offers-filters__submit">Apply</button>
            <a class="button button--ghost offers-filters__reset" href="<?= e(url('/offres')) ?>">Reset</a>
        </div>
    </form>

    <?php if ($managementPath !== null): ?>
        <div class="offers-toolbar">
            <p class="meta">You also have direct management access from your dashboard.</p>
            <a class="button button--secondary" href="<?= e(url($managementPath)) ?>">Manage offers</a>
        </div>
    <?php endif; ?>

    <div class="offers-section-heading">
        <div>
            <h2>Featured internships</h2>
            <p class="meta">
                <?= $total ?> result<?= $total > 1 ? 's' : '' ?>
                <?php if ($total > 0): ?>
                    · page <?= $currentPage ?> of <?= $lastPage ?>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <?php if ($offers === []): ?>
        <div class="panel empty-state">
            <h2>No internships found</h2>
            <p>Try different search terms or reset the filters.</p>
        </div>
    <?php else: ?>
        <div class="offers-grid">
            <?php foreach ($offers as $offer): ?>
                <?php
                $initials = strtoupper(substr((string) $offer['company_name'], 0, 2));
                $tags = $buildTags($offer);
                ?>
                <article class="offer-card">
                    <div class="offer-card__header">
                        <div class="offer-card__brand">
                            <span class="offer-card__logo"><?= e($initials) ?></span>
                            <div>
                                <h3><?= e((string) $offer['title']) ?></h3>
                                <p class="meta"><?= e((string) $offer['company_name']) ?></p>
                            </div>
                        </div>
                        <span class="offer-card__flag">Featured</span>
                    </div>

                    <ul class="offer-card__meta">
                        <li><?= e((string) $offer['location']) ?></li>
                        <li><?= e((string) $offer['contract_type']) ?></li>
                        <li><?= e($formatPostedAgo((string) ($offer['created_at'] ?? ''))) ?></li>
                    </ul>

                    <p class="offer-card__description">
                        <?= e(mb_strimwidth((string) $offer['description'], 0, 150, '...')) ?>
                    </p>

                    <?php if ($tags !== []): ?>
                        <div class="offer-card__tags">
                            <?php foreach ($tags as $tag): ?>
                                <span><?= e($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="offer-card__footer">
                        <span class="meta"><?= e($formatPostedAgo((string) ($offer['created_at'] ?? ''))) ?></span>
                        <a href="<?= e(url('/offres/' . $offer['id'])) ?>">View details →</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($lastPage > 1): ?>
        <nav class="pagination pagination--offers" aria-label="Pagination">
            <?php if ($currentPage > 1): ?>
                <a href="<?= e(url_with_query('/offres', [...$filters, 'page' => $currentPage - 1])) ?>">Previous</a>
            <?php endif; ?>
            <?php for ($page = 1; $page <= $lastPage; $page++): ?>
                <a class="<?= $page === $currentPage ? 'is-active' : '' ?>" <?= $page === $currentPage ? 'aria-current="page"' : '' ?> href="<?= e(url_with_query('/offres', [...$filters, 'page' => $page])) ?>"><?= $page ?></a>
            <?php endfor; ?>
            <?php if ($currentPage < $lastPage): ?>
                <a href="<?= e(url_with_query('/offres', [...$filters, 'page' => $currentPage + 1])) ?>">Next</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</section>

<section class="container offers-extra">
    <div class="offers-extra__grid">
        <article class="offers-extra__panel">
            <span class="eyebrow">Browse by focus</span>
            <h2>Explore by city, contract, and company.</h2>
            <p class="meta">
                Start from the search bar, then refine by the internship format and locations that match your goals.
            </p>

            <?php if ($locations !== []): ?>
                <div class="offers-chip-group">
                    <?php foreach ($locations as $location): ?>
                        <a href="<?= e(url_with_query('/offres', [...$filters, 'location' => (string) $location, 'page' => 1])) ?>"><?= e((string) $location) ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($contractTypes !== []): ?>
                <div class="offers-chip-group offers-chip-group--secondary">
                    <?php foreach ($contractTypes as $contractType): ?>
                        <a href="<?= e(url_with_query('/offres', [...$filters, 'contract_type' => (string) $contractType, 'page' => 1])) ?>"><?= e((string) $contractType) ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </article>

        <article class="offers-extra__panel">
            <span class="eyebrow">Partner network</span>
            <h2>Trusted companies across multiple sectors.</h2>
            <p class="meta">
                InternHub connects internship opportunities with companies already structured in the platform.
            </p>

            <div class="offers-company-cloud">
                <?php foreach (($featuredCompanies ?? []) as $company): ?>
                    <a href="<?= e(url('/entreprises/' . $company['id'])) ?>"><?= e((string) $company['name']) ?></a>
                <?php endforeach; ?>
            </div>
        </article>
    </div>
</section>

<section class="container offers-story">
    <div class="section-heading">
        <span class="eyebrow">Why students use InternHub</span>
        <h2>A clearer path from internship search to application follow-up.</h2>
        <p class="meta">
            The platform is designed to reduce friction for students while keeping coordinators and administrators in control.
        </p>
    </div>

    <div class="offers-story__grid">
        <article class="offers-story__card">
            <div class="marketing-icon">01</div>
            <h3>Search with structure</h3>
            <p>Find opportunities through searchable titles, companies, cities, and contract formats.</p>
        </article>
        <article class="offers-story__card">
            <div class="marketing-icon">02</div>
            <h3>Apply in one workflow</h3>
            <p>Submit your application through a guided process with document handling and status tracking.</p>
        </article>
        <article class="offers-story__card">
            <div class="marketing-icon">03</div>
            <h3>Stay aligned with your program</h3>
            <p>Students, coordinators, and administrators all work in the same controlled platform.</p>
        </article>
    </div>
</section>

<section class="container offers-process">
    <div class="offers-process__shell">
        <div class="section-heading section-heading--compact">
            <span class="eyebrow">Application flow</span>
            <h2>From discovery to follow-up in three steps.</h2>
        </div>

        <div class="offers-process__steps">
            <article class="offers-process__step">
                <span>1</span>
                <h3>Discover relevant offers</h3>
                <p>Browse internship openings, company details, and the role format that fits your search.</p>
            </article>
            <article class="offers-process__step">
                <span>2</span>
                <h3>Submit your application</h3>
                <p>Apply through InternHub with a structured form, document upload, and clear permissions.</p>
            </article>
            <article class="offers-process__step">
                <span>3</span>
                <h3>Track and coordinate</h3>
                <p>Follow your submissions while coordinators monitor progress from their dedicated workspace.</p>
            </article>
        </div>
    </div>
</section>
