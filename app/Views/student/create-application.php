<?php

declare(strict_types=1);
?>
<section class="container application-form-page">
    <div class="application-form-page__back">
        <a class="application-form-page__back-link" href="<?= e(url('/offres/' . $offer['id'])) ?>">← Back to internship detail</a>
    </div>

    <div class="application-form-page__hero">
        <div class="application-form-page__hero-copy">
            <span class="eyebrow">Application</span>
            <h1>Apply to <?= e((string) $offer['title']) ?></h1>
            <p class="lead">
                Submit your motivation letter and your PDF CV for this opportunity in one clear step.
            </p>

            <ul class="application-form-page__meta">
                <li><?= e((string) $offer['company_name']) ?></li>
                <li><?= e((string) $offer['location']) ?></li>
                <li><?= e((string) $offer['contract_type']) ?></li>
            </ul>
        </div>

        <aside class="application-form-page__hero-card">
            <span class="eyebrow">What you need</span>
            <h2>A simple and structured submission.</h2>
            <p class="meta">
                Before sending your application, make sure your message is detailed enough and your CV is provided as a PDF file.
            </p>
        </aside>
    </div>
</section>

<section class="container application-form-layout">
    <div class="application-form-layout__main">
        <article class="application-form-panel">
            <div class="section-heading section-heading--compact">
                <div>
                    <span class="eyebrow">Application form</span>
                    <h2>Complete your submission</h2>
                </div>
            </div>

            <form method="post" action="<?= e(url('/offres/' . $offer['id'] . '/postuler')) ?>" enctype="multipart/form-data" class="stack-form application-form">
                <?= csrf_field() ?>

                <label class="field">
                    <span>Motivation letter</span>
                    <textarea name="cover_letter" rows="9" required placeholder="Explain why this internship matches your profile, your goals, and the value you can bring."><?= e((string) $coverLetter) ?></textarea>
                    <small class="field-hint">Write a clear message that helps the reviewer understand your interest and your fit.</small>
                    <?php if (! empty($errors['cover_letter'])): ?>
                        <small class="field-error"><?= e($errors['cover_letter']) ?></small>
                    <?php endif; ?>
                </label>

                <label class="field">
                    <span>CV file</span>
                    <input type="file" name="cv" accept="application/pdf" required>
                    <small class="field-hint">Accepted format: PDF only. Maximum file size: 2 MB.</small>
                    <?php if (! empty($errors['cv'])): ?>
                        <small class="field-error"><?= e($errors['cv']) ?></small>
                    <?php endif; ?>
                </label>

                <div class="application-form__actions">
                    <button type="submit" class="button button--primary">Send my application</button>
                    <a class="button button--ghost" href="<?= e(url('/offres/' . $offer['id'])) ?>">Cancel</a>
                </div>
            </form>
        </article>
    </div>

    <aside class="application-form-layout__aside">
        <div class="application-form-panel application-form-panel--soft">
            <span class="eyebrow">Submission guidance</span>
            <h2>What happens next?</h2>
            <p class="meta">
                Once submitted, your application will appear in your student dashboard and in your applications list. You will then be able to review the submission and download the CV you uploaded.
            </p>

            <ul class="application-form-checklist">
                <li>Review the internship title and company before sending.</li>
                <li>Keep your motivation letter specific to this opportunity.</li>
                <li>Use a readable PDF CV with the latest information.</li>
            </ul>
        </div>
    </aside>
</section>
