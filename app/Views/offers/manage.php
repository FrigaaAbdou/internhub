<?php

declare(strict_types=1);

$publishedCount = 0;
$draftCount = 0;
$blockedDeletionCount = 0;
$dashboardPath = str_starts_with((string) $managementPath, '/admin') ? '/dashboard/admin' : '/dashboard/pilote';

foreach ($offers as $offer) {
    if ((int) ($offer['is_published'] ?? 0) === 1) {
        $publishedCount++;
    } else {
        $draftCount++;
    }

    if ((int) ($offer['application_count'] ?? 0) > 0) {
        $blockedDeletionCount++;
    }
}
?>
<section class="container offer-management-page">
    <div class="offer-management__hero">
        <div class="offer-management__copy">
            <span class="eyebrow"><?= e($roleLabel) ?> space</span>
            <h1>Manage offers</h1>
            <p class="lead">
                Search the offer catalog, review publication status, and move quickly into edit or controlled deletion actions.
            </p>
        </div>

        <aside class="offer-management__hero-card">
            <span class="eyebrow">Offer overview</span>
            <div class="offer-management__summary">
                <div>
                    <dt>Published</dt>
                    <dd><?= e((string) $publishedCount) ?></dd>
                </div>
                <div>
                    <dt>Drafts</dt>
                    <dd><?= e((string) $draftCount) ?></dd>
                </div>
                <div>
                    <dt>Protected from delete</dt>
                    <dd><?= e((string) $blockedDeletionCount) ?></dd>
                </div>
            </div>
        </aside>
    </div>
</section>

<section class="container offer-management__content">
    <div class="offer-management__main">
        <article class="offer-management-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Operational management</span>
                    <h2>Review and act on internship offers.</h2>
                </div>
                <a class="button button--primary" href="<?= e(url($managementPath . '/create')) ?>">Create offer</a>
            </div>

            <form method="get" class="offer-management-search">
                <label class="field">
                    <span class="sr-only">Search offers</span>
                    <input type="search" name="q" value="<?= e($search) ?>" placeholder="Search by title, company, or location">
                </label>
                <button type="submit" class="button button--secondary">Search</button>
            </form>

            <p class="results-summary">
                <?= $total ?> offer<?= $total > 1 ? 's' : '' ?> managed
                <?php if ($total > 0): ?>
                    · page <?= $currentPage ?> of <?= $lastPage ?>
                <?php endif; ?>
                <?php if ($search !== ''): ?>
                    · search: “<?= e($search) ?>”
                <?php endif; ?>
            </p>

            <?php if ($offers === []): ?>
                <div class="empty-state">
                    <h2>No offers to manage</h2>
                    <p>Create a new offer or broaden your search to see more results in this module.</p>
                </div>
            <?php else: ?>
                <div class="offer-management-list">
                    <?php foreach ($offers as $offer): ?>
                        <?php $isPublished = (int) ($offer['is_published'] ?? 0) === 1; ?>
                        <?php $applicationCount = (int) ($offer['application_count'] ?? 0); ?>
                        <article class="offer-management-item">
                            <div class="offer-management-item__header">
                                <div>
                                    <h3><?= e((string) $offer['title']) ?></h3>
                                    <p class="meta"><?= e((string) $offer['company_name']) ?> · <?= e((string) $offer['location']) ?></p>
                                </div>

                                <span class="offer-management-status offer-management-status--<?= $isPublished ? 'published' : 'draft' ?>">
                                    <?= $isPublished ? 'Published' : 'Draft' ?>
                                </span>
                            </div>

                            <dl class="offer-management-item__meta">
                                <div>
                                    <dt>Contract</dt>
                                    <dd><?= e((string) $offer['contract_type']) ?></dd>
                                </div>
                                <div>
                                    <dt>Applications</dt>
                                    <dd><?= e((string) $applicationCount) ?></dd>
                                </div>
                            </dl>

                            <div class="offer-management-item__actions">
                                <?php if ($isPublished): ?>
                                    <a href="<?= e(url('/offres/' . $offer['id'])) ?>">View</a>
                                <?php endif; ?>
                                <a href="<?= e(url($managementPath . '/' . $offer['id'] . '/edit')) ?>">Edit</a>
                                <form method="post" action="<?= e(url($managementPath . '/' . $offer['id'] . '/delete')) ?>" class="inline-form">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="button-link danger-link" <?= $applicationCount > 0 ? 'disabled aria-disabled="true" title="Delete is blocked while applications remain attached to this offer."' : '' ?>>
                                        Delete
                                    </button>
                                </form>
                            </div>

                            <?php if ($applicationCount > 0): ?>
                                <p class="offer-management-item__note">
                                    Deletion is blocked because this offer already has one or more linked applications.
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

    <aside class="offer-management__aside">
        <div class="offer-management-card offer-management-card--soft">
            <span class="eyebrow">Management guidance</span>
            <h2>Keep offer operations clear.</h2>
            <p class="meta">
                Published offers are visible publicly. Drafts stay internal until ready. Deletion should remain exceptional when candidate data already exists.
            </p>

            <div class="offer-management-card__stack">
                <a class="button button--primary" href="<?= e(url($managementPath . '/create')) ?>">Create offer</a>
                <a class="button button--ghost" href="<?= e(url($dashboardPath)) ?>">Back to dashboard</a>
                <a class="button button--ghost" href="<?= e(url('/statistiques')) ?>">Open statistics</a>
            </div>
        </div>
    </aside>
</section>
</section>
