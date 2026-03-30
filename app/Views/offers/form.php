<?php

declare(strict_types=1);

$isEdit = str_contains(mb_strtolower((string) $title), 'modifier');
$pageEyebrow = $isEdit ? 'Offer edition' : 'Offer creation';
$heroTitle = $isEdit ? 'Edit offer' : 'Create offer';
$heroDescription = $isEdit
    ? 'Update offer content, publication state, and company assignment without breaking the catalog coherence.'
    : 'Create a structured internship offer with the right company, contract type, and publication status.';
?>
<section class="container offer-form-page">
    <div class="offer-form__hero">
        <div class="offer-form__copy">
            <span class="eyebrow"><?= e($roleLabel) ?> space</span>
            <h1><?= e($heroTitle) ?></h1>
            <p class="lead">
                <?= e($heroDescription) ?>
            </p>
        </div>

        <aside class="offer-form__hero-card">
            <span class="eyebrow"><?= e($pageEyebrow) ?></span>
            <h2><?= $isEdit ? 'Refine the offer before changing visibility' : 'Set the offer up clearly from the start' ?></h2>
            <p class="meta">
                The company, descriptive fields, and publication setting should stay aligned so the offer is easy to manage and clear to students.
            </p>
        </aside>
    </div>
</section>

<section class="container offer-form__content">
    <div class="offer-form__main">
        <article class="offer-management-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Offer fields</span>
                    <h2><?= $isEdit ? 'Update the offer information.' : 'Configure the new internship offer.' ?></h2>
                </div>
            </div>

            <form method="post" action="<?= e(url($formAction)) ?>" class="stack-form offer-form">
                <?= csrf_field() ?>

                <label class="field">
                    <span>Company</span>
                    <select name="company_id" required>
                        <option value="">Choisir une entreprise</option>
                        <?php foreach ($companies as $company): ?>
                            <option value="<?= e((string) $company['id']) ?>" <?= (string) ($values['company_id'] ?? '') === (string) $company['id'] ? 'selected' : '' ?>>
                                <?= e((string) $company['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="field-hint">Link the offer to the correct company profile before publication.</small>
                    <?php if (! empty($errors['company_id'])): ?>
                        <small class="field-error"><?= e($errors['company_id']) ?></small>
                    <?php endif; ?>
                </label>

                <label class="field">
                    <span>Title</span>
                    <input type="text" name="title" value="<?= e((string) ($values['title'] ?? '')) ?>" required>
                    <?php if (! empty($errors['title'])): ?>
                        <small class="field-error"><?= e($errors['title']) ?></small>
                    <?php endif; ?>
                </label>

                <div class="field-row">
                    <label class="field">
                        <span>Location</span>
                        <input type="text" name="location" value="<?= e((string) ($values['location'] ?? '')) ?>" required>
                        <?php if (! empty($errors['location'])): ?>
                            <small class="field-error"><?= e($errors['location']) ?></small>
                        <?php endif; ?>
                    </label>

                    <label class="field">
                        <span>Contract type</span>
                        <input type="text" name="contract_type" value="<?= e((string) ($values['contract_type'] ?? '')) ?>" required>
                        <?php if (! empty($errors['contract_type'])): ?>
                            <small class="field-error"><?= e($errors['contract_type']) ?></small>
                        <?php endif; ?>
                    </label>
                </div>

                <label class="field">
                    <span>Description</span>
                    <textarea name="description" required><?= e((string) ($values['description'] ?? '')) ?></textarea>
                    <small class="field-hint">Describe the mission, expected profile, and context in a clear way for applicants.</small>
                    <?php if (! empty($errors['description'])): ?>
                        <small class="field-error"><?= e($errors['description']) ?></small>
                    <?php endif; ?>
                </label>

                <div class="offer-form__publication">
                    <div class="section-heading section-heading--compact">
                        <div>
                            <span class="eyebrow">Publication</span>
                            <h2><?= $isEdit ? 'Adjust catalog visibility' : 'Choose the first visibility state' ?></h2>
                        </div>
                    </div>

                    <label class="checkbox-field">
                        <input type="checkbox" name="is_published" value="1" <?= (string) ($values['is_published'] ?? '0') === '1' ? 'checked' : '' ?>>
                        <span>Publish this offer immediately</span>
                    </label>
                    <p class="meta">Published offers appear in the public catalog. Unchecked offers remain as drafts.</p>
                </div>

                <div class="offer-form__actions">
                    <button type="submit" class="button button--primary">Save offer</button>
                    <a class="button button--ghost" href="<?= e(url($cancelPath)) ?>">Back to offers</a>
                </div>
            </form>
        </article>
    </div>

    <aside class="offer-form__aside">
        <div class="offer-management-card offer-management-card--soft">
            <span class="eyebrow">Management guidance</span>
            <h2><?= $isEdit ? 'Update content before switching status.' : 'Create a publish-ready offer.' ?></h2>
            <p class="meta">
                A clear title, the right company link, and a readable description reduce confusion for both managers and applicants.
            </p>

            <div class="offer-management-card__stack">
                <a class="button button--primary" href="<?= e(url($cancelPath)) ?>">Back to offers</a>
                <a class="button button--ghost" href="<?= e(url('/statistiques')) ?>">Open statistics</a>
            </div>
        </div>
    </aside>
</section>
