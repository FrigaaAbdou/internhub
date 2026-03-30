<?php

declare(strict_types=1);

$companyWithOffersCount = 0;
$companyWithoutOffersCount = 0;
$dashboardPath = str_starts_with((string) $managementPath, '/admin') ? '/dashboard/admin' : '/dashboard/pilote';

foreach ($companies as $company) {
    if ((int) ($company['offer_count'] ?? 0) > 0) {
        $companyWithOffersCount++;
    } else {
        $companyWithoutOffersCount++;
    }
}
?>
<section class="container company-management-page">
    <div class="company-management__hero">
        <div class="company-management__copy">
            <span class="eyebrow"><?= e($roleLabel) ?> space</span>
            <h1>Manage companies</h1>
            <p class="lead">
                Search the company directory, review operational status, and access edit or controlled deletion actions from one management view.
            </p>
        </div>

        <aside class="company-management__hero-card">
            <span class="eyebrow">Company overview</span>
            <div class="company-management__summary">
                <div>
                    <dt>Total companies</dt>
                    <dd><?= e((string) $total) ?></dd>
                </div>
                <div>
                    <dt>With offers</dt>
                    <dd><?= e((string) $companyWithOffersCount) ?></dd>
                </div>
                <div>
                    <dt>Ready to delete</dt>
                    <dd><?= e((string) $companyWithoutOffersCount) ?></dd>
                </div>
            </div>
        </aside>
    </div>
</section>

<section class="container company-management__content">
    <div class="company-management__main">
        <article class="company-management-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Operational management</span>
                    <h2>Review and maintain company records.</h2>
                </div>
                <a class="button button--primary" href="<?= e(url($managementPath . '/create')) ?>">Create company</a>
            </div>

            <form method="get" class="company-management-search">
                <label class="field">
                    <span class="sr-only">Search companies</span>
                    <input type="search" name="q" value="<?= e($search) ?>" placeholder="Search by name, industry, or city">
                </label>
                <button type="submit" class="button button--secondary">Search</button>
            </form>

            <p class="results-summary">
                <?= $total ?> compan<?= $total > 1 ? 'ies' : 'y' ?> managed
                <?php if ($total > 0): ?>
                    · page <?= $currentPage ?> of <?= $lastPage ?>
                <?php endif; ?>
                <?php if ($search !== ''): ?>
                    · search: “<?= e($search) ?>”
                <?php endif; ?>
            </p>

            <?php if ($companies === []): ?>
                <div class="empty-state">
                    <h2>No companies to manage</h2>
                    <p>Create a company first to start attaching offers to the internship catalog.</p>
                </div>
            <?php else: ?>
                <div class="company-management-list">
                    <?php foreach ($companies as $company): ?>
                        <?php $offerCount = (int) ($company['offer_count'] ?? 0); ?>
                        <article class="company-management-item">
                            <div class="company-management-item__header">
                                <div>
                                    <h3><?= e((string) $company['name']) ?></h3>
                                    <p class="meta"><?= e((string) $company['industry']) ?> · <?= e((string) $company['city']) ?></p>
                                </div>

                                <span class="company-management-status company-management-status--<?= $offerCount > 0 ? 'active' : 'idle' ?>">
                                    <?= $offerCount > 0 ? 'Linked to offers' : 'No linked offers' ?>
                                </span>
                            </div>

                            <dl class="company-management-item__meta">
                                <div>
                                    <dt>Published or linked offers</dt>
                                    <dd><?= e((string) $offerCount) ?></dd>
                                </div>
                                <div>
                                    <dt>Website</dt>
                                    <dd>
                                        <?php if (! empty($company['website'])): ?>
                                            <a href="<?= e((string) $company['website']) ?>" target="_blank" rel="noreferrer">Visit site</a>
                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </dd>
                                </div>
                            </dl>

                            <div class="company-management-item__actions">
                                <a href="<?= e(url('/entreprises/' . $company['id'])) ?>">View</a>
                                <a href="<?= e(url($managementPath . '/' . $company['id'] . '/edit')) ?>">Edit</a>
                                <form method="post" action="<?= e(url($managementPath . '/' . $company['id'] . '/delete')) ?>" class="inline-form">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="button-link danger-link" <?= $offerCount > 0 ? 'disabled aria-disabled="true" title="Delete is blocked while offers remain attached to this company."' : '' ?>>
                                        Delete
                                    </button>
                                </form>
                            </div>

                            <?php if ($offerCount > 0): ?>
                                <p class="company-management-item__note">
                                    Deletion is blocked because one or more offers are still linked to this company.
                                </p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($lastPage > 1): ?>
                <nav class="pagination" aria-label="Pagination">
                    <?php for ($page = 1; $page <= $lastPage; $page++): ?>
                        <a class="<?= $page === $currentPage ? 'is-active' : '' ?>" <?= $page === $currentPage ? 'aria-current="page"' : '' ?> href="<?= e(url_with_query($managementPath, ['q' => $search, 'page' => $page])) ?>"><?= $page ?></a>
                    <?php endfor; ?>
                </nav>
            <?php endif; ?>
        </article>
    </div>

    <aside class="company-management__aside">
        <div class="company-management-card company-management-card--soft">
            <span class="eyebrow">Management guidance</span>
            <h2>Keep company records reliable.</h2>
            <p class="meta">
                Company profiles should stay clean and well linked. Deletion should only happen when no offers still depend on the record.
            </p>

            <div class="company-management-card__stack">
                <a class="button button--primary" href="<?= e(url($managementPath . '/create')) ?>">Create company</a>
                <a class="button button--ghost" href="<?= e(url($dashboardPath)) ?>">Back to dashboard</a>
                <a class="button button--ghost" href="<?= e(url('/statistiques')) ?>">Open statistics</a>
            </div>
        </div>
    </aside>
</section>
</section>
