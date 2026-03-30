<?php

declare(strict_types=1);
?>
<section class="container companies-showcase">
    <div class="companies-showcase__hero">
        <div class="companies-showcase__copy">
            <span class="eyebrow">Partner companies</span>
            <h1>Explore the companies behind the opportunities</h1>
            <p class="lead">
                Browse the organizations already structured inside InternHub and understand where internship opportunities come from.
            </p>
            <ul class="companies-showcase__stats">
                <li><span class="stat-dot stat-dot--violet"></span><strong><?= $total ?>+</strong> companies listed</li>
                <li><span class="stat-dot stat-dot--green"></span><strong><?= $offerCount ?>+</strong> active internships</li>
                <li><span class="stat-dot stat-dot--blue"></span><strong><?= $cityCount ?>+</strong> cities covered</li>
            </ul>
        </div>

        <aside class="companies-showcase__panel" aria-label="Company network overview">
            <span class="eyebrow">Network overview</span>
            <h2>A structured company directory, not just a list of names.</h2>
            <p class="meta">
                Companies are organized as part of the same workflow as offers and applications, which makes the ecosystem easier to browse and understand.
            </p>
            <div class="companies-showcase__metrics">
                <div>
                    <strong><?= $industryCount ?></strong>
                    <span>sectors represented</span>
                </div>
                <div>
                    <strong><?= $cityCount ?></strong>
                    <span>locations available</span>
                </div>
            </div>
        </aside>
    </div>

    <form method="get" class="companies-search">
        <div class="companies-search__field">
            <span class="companies-search__icon" aria-hidden="true">⌕</span>
            <input
                type="search"
                name="q"
                value="<?= e($search) ?>"
                placeholder="Search by company, sector, or city..."
                aria-label="Search companies"
            >
        </div>
        <button type="submit" class="button button--primary">Search</button>
        <a class="button button--ghost" href="<?= e(url('/entreprises')) ?>">Reset</a>
    </form>

    <?php if ($managementPath !== null): ?>
        <div class="offers-toolbar">
            <p class="meta">You also have direct management access from your dashboard.</p>
            <a class="button button--secondary" href="<?= e(url($managementPath)) ?>">Manage companies</a>
        </div>
    <?php endif; ?>

    <div class="offers-section-heading">
        <div>
            <h2>Company directory</h2>
            <p class="meta">
                <?= $total ?> result<?= $total > 1 ? 's' : '' ?>
                <?php if ($total > 0): ?>
                    · page <?= $currentPage ?> of <?= $lastPage ?>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <?php if ($companies === []): ?>
        <div class="panel empty-state">
            <h2>No companies found</h2>
            <p>Try a different company name, sector, or city.</p>
        </div>
    <?php else: ?>
        <div class="companies-grid">
            <?php foreach ($companies as $company): ?>
                <?php
                $initials = strtoupper(substr((string) $company['name'], 0, 2));
                $website = trim((string) ($company['website'] ?? ''));
                $offerCountLabel = (int) ($company['offer_count'] ?? 0);
                ?>
                <article class="company-card">
                    <div class="company-card__header">
                        <div class="company-card__brand">
                            <span class="company-card__logo"><?= e($initials) ?></span>
                            <div>
                                <h3><?= e((string) $company['name']) ?></h3>
                                <p class="meta"><?= e((string) $company['industry']) ?></p>
                            </div>
                        </div>
                        <span class="company-card__flag"><?= $offerCountLabel ?> active offer<?= $offerCountLabel > 1 ? 's' : '' ?></span>
                    </div>

                    <ul class="company-card__meta">
                        <li><?= e((string) $company['city']) ?></li>
                        <li><?= e((string) $company['industry']) ?></li>
                    </ul>

                    <p class="company-card__description">
                        <?= e(mb_strimwidth((string) $company['description'], 0, 170, '...')) ?>
                    </p>

                    <div class="company-card__footer">
                        <?php if ($website !== ''): ?>
                            <a href="<?= e($website) ?>" target="_blank" rel="noreferrer">Visit website</a>
                        <?php else: ?>
                            <span class="meta">Company profile available on InternHub</span>
                        <?php endif; ?>
                        <a href="<?= e(url('/entreprises/' . $company['id'])) ?>">View company →</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($lastPage > 1): ?>
        <nav class="pagination pagination--offers" aria-label="Pagination">
            <?php if ($currentPage > 1): ?>
                <a href="<?= e(url_with_query('/entreprises', ['q' => $search, 'page' => $currentPage - 1])) ?>">Previous</a>
            <?php endif; ?>
            <?php for ($page = 1; $page <= $lastPage; $page++): ?>
                <a class="<?= $page === $currentPage ? 'is-active' : '' ?>" <?= $page === $currentPage ? 'aria-current="page"' : '' ?> href="<?= e(url_with_query('/entreprises', ['q' => $search, 'page' => $page])) ?>"><?= $page ?></a>
            <?php endfor; ?>
            <?php if ($currentPage < $lastPage): ?>
                <a href="<?= e(url_with_query('/entreprises', ['q' => $search, 'page' => $currentPage + 1])) ?>">Next</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</section>

<?php if ($featuredIndustries !== [] || $featuredCities !== []): ?>
    <section class="container companies-extra">
        <div class="companies-extra__grid">
            <?php if ($featuredIndustries !== []): ?>
                <article class="companies-extra__panel">
                    <span class="eyebrow">Browse by sector</span>
                    <h2>Companies across multiple internship domains.</h2>
                    <p class="meta">
                        The directory is structured to make sectors visible before you even open a company profile.
                    </p>
                    <div class="companies-chip-group">
                        <?php foreach ($featuredIndustries as $industry): ?>
                            <a href="<?= e(url_with_query('/entreprises', ['q' => (string) $industry, 'page' => 1])) ?>"><?= e((string) $industry) ?></a>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endif; ?>

            <?php if ($featuredCities !== []): ?>
                <article class="companies-extra__panel">
                    <span class="eyebrow">Browse by city</span>
                    <h2>Explore the network by location.</h2>
                    <p class="meta">
                        Use city-level browsing to quickly identify where companies are already active in the platform.
                    </p>
                    <div class="companies-chip-group companies-chip-group--secondary">
                        <?php foreach ($featuredCities as $city): ?>
                            <a href="<?= e(url_with_query('/entreprises', ['q' => (string) $city, 'page' => 1])) ?>"><?= e((string) $city) ?></a>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
