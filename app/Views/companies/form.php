<?php

declare(strict_types=1);

$isEdit = str_contains(mb_strtolower((string) $title), 'modifier');
$pageEyebrow = $isEdit ? 'Company edition' : 'Company creation';
$heroTitle = $isEdit ? 'Edit company' : 'Create company';
$heroDescription = $isEdit
    ? 'Update the company profile while keeping the directory clean, reliable, and ready for linked offers.'
    : 'Create a structured company profile with clear identity, sector, location, and presentation details.';
?>
<section class="container company-form-page">
    <div class="company-form__hero">
        <div class="company-form__copy">
            <span class="eyebrow"><?= e($roleLabel) ?> space</span>
            <h1><?= e($heroTitle) ?></h1>
            <p class="lead">
                <?= e($heroDescription) ?>
            </p>
        </div>

        <aside class="company-form__hero-card">
            <span class="eyebrow"><?= e($pageEyebrow) ?></span>
            <h2><?= $isEdit ? 'Refine the company record before operational changes' : 'Set up the company profile clearly from the start' ?></h2>
            <p class="meta">
                The company profile should stay clean, readable, and ready to support linked internship offers across the catalog.
            </p>
        </aside>
    </div>
</section>

<section class="container company-form__content">
    <div class="company-form__main">
        <article class="company-management-card">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Company fields</span>
                    <h2><?= $isEdit ? 'Update the company information.' : 'Configure the new company profile.' ?></h2>
                </div>
            </div>

            <form method="post" action="<?= e(url($formAction)) ?>" class="stack-form company-form">
                <?= csrf_field() ?>

                <label class="field">
                    <span>Name</span>
                    <input type="text" name="name" value="<?= e((string) ($values['name'] ?? '')) ?>" required>
                    <?php if (! empty($errors['name'])): ?>
                        <small class="field-error"><?= e($errors['name']) ?></small>
                    <?php endif; ?>
                </label>

                <div class="field-row">
                    <label class="field">
                        <span>Industry</span>
                        <input type="text" name="industry" value="<?= e((string) ($values['industry'] ?? '')) ?>" required>
                        <?php if (! empty($errors['industry'])): ?>
                            <small class="field-error"><?= e($errors['industry']) ?></small>
                        <?php endif; ?>
                    </label>

                    <label class="field">
                        <span>City</span>
                        <input type="text" name="city" value="<?= e((string) ($values['city'] ?? '')) ?>" required>
                        <?php if (! empty($errors['city'])): ?>
                            <small class="field-error"><?= e($errors['city']) ?></small>
                        <?php endif; ?>
                    </label>
                </div>

                <label class="field">
                    <span>Website</span>
                    <input type="url" name="website" value="<?= e((string) ($values['website'] ?? '')) ?>" placeholder="https://example.com">
                    <small class="field-hint">Add the official company website if it is available.</small>
                    <?php if (! empty($errors['website'])): ?>
                        <small class="field-error"><?= e($errors['website']) ?></small>
                    <?php endif; ?>
                </label>

                <label class="field">
                    <span>Description</span>
                    <textarea name="description" required><?= e((string) ($values['description'] ?? '')) ?></textarea>
                    <small class="field-hint">Describe the company clearly so students can understand its context and positioning.</small>
                    <?php if (! empty($errors['description'])): ?>
                        <small class="field-error"><?= e($errors['description']) ?></small>
                    <?php endif; ?>
                </label>

                <div class="company-form__actions">
                    <button type="submit" class="button button--primary">Save company</button>
                    <a class="button button--ghost" href="<?= e(url($cancelPath)) ?>">Back to companies</a>
                </div>
            </form>
        </article>
    </div>

    <aside class="company-form__aside">
        <div class="company-management-card company-management-card--soft">
            <span class="eyebrow">Management guidance</span>
            <h2><?= $isEdit ? 'Keep the company profile coherent.' : 'Create a company record that is ready for offers.' ?></h2>
            <p class="meta">
                A reliable name, sector, city, and description make the company easier to manage internally and clearer to students publicly.
            </p>

            <div class="company-management-card__stack">
                <a class="button button--primary" href="<?= e(url($cancelPath)) ?>">Back to companies</a>
                <a class="button button--ghost" href="<?= e(url('/statistiques')) ?>">Open statistics</a>
            </div>
        </div>
    </aside>
</section>
