<?php

declare(strict_types=1);
?>
<section class="landing-hero">
    <div class="container landing-hero__grid">
        <div class="landing-hero__copy">
            <span class="eyebrow">Internship management platform</span>
            <h1>Find and manage internships with <span class="accent-text"><?= e($appName) ?></span>.</h1>
            <p class="lead">
                A centralized platform for internship offers, companies, and applications, designed for students,
                coordinators, and academic teams.
            </p>
            <div class="hero__actions">
                <a class="button button--primary" href="<?= e(url('/offres')) ?>">Explore internships</a>
                <a class="button button--secondary" href="#how-it-works">See how it works</a>
            </div>
            <ul class="hero-proof">
                <li>Role-based access for students, coordinators, and administrators</li>
                <li>Secure application workflows with clear ownership</li>
                <li>One structured path from discovery to follow-up</li>
            </ul>
        </div>
        <aside class="hero-showcase" aria-label="Apercu produit InternHub">
            <div class="hero-image-shell">
                <img
                    class="hero-image"
                    src="<?= e(asset('/assets/hero.png')) ?>"
                    alt="Illustration produit InternHub montrant une experience moderne de gestion des stages"
                >
            </div>
        </aside>
    </div>
</section>

<section class="container metrics-band" aria-label="Indicateurs clefs">
    <article class="metric-card">
        <strong>500+</strong>
        <span>Internship offers</span>
    </article>
    <article class="metric-card">
        <strong>120+</strong>
        <span>Partner companies</span>
    </article>
    <article class="metric-card">
        <strong>3</strong>
        <span>User roles, one shared workflow</span>
    </article>
    <article class="metric-card">
        <strong>10K+</strong>
        <span>Managed applications</span>
    </article>
</section>

<section id="product" class="container landing-section">
    <div class="section-heading">
        <span class="eyebrow">Product</span>
        <h2>Everything internship management needs, in one place.</h2>
        <p class="meta">
            InternHub unifies internship offers, companies, student applications, and role-based follow-up in one structured platform.
        </p>
    </div>
    <div class="marketing-grid">
        <article class="marketing-card">
            <div class="marketing-icon">01</div>
            <h3>Centralized internship management</h3>
            <p>Offers, companies, and student applications are handled in one structured workflow.</p>
        </article>
        <article class="marketing-card">
            <div class="marketing-icon">02</div>
            <h3>Guided student journey</h3>
            <p>Students can explore opportunities, apply, and track progress without scattered tools.</p>
        </article>
        <article class="marketing-card">
            <div class="marketing-icon">03</div>
            <h3>Clear coordination and access control</h3>
            <p>Pilots and administrators manage their scope through dashboards, permissions, and guarded actions.</p>
        </article>
    </div>
</section>

<section id="for-schools" class="container landing-section landing-section--soft">
    <div class="section-heading">
        <span class="eyebrow">For every actor</span>
        <h2>Built for every actor in the internship process.</h2>
        <p class="meta">
            The platform stays useful for students while giving coordinators and institutions a clearer operational view.
        </p>
    </div>
    <div class="audience-grid">
        <article class="audience-card">
            <span class="audience-card__badge">Students</span>
            <h3>Browse, apply, and track</h3>
            <p>Browse offers, review company details, submit applications, and track progress in one place.</p>
        </article>
        <article class="audience-card">
            <span class="audience-card__badge">Program coordinators</span>
            <h3>Supervise with structure</h3>
            <p>Follow student activity, review submissions, and manage accounts inside a clear academic workflow.</p>
        </article>
        <article class="audience-card">
            <span class="audience-card__badge">Institutions</span>
            <h3>Keep internship management reliable</h3>
            <p>Move from scattered documents and manual tracking to a more consistent and auditable process.</p>
        </article>
    </div>
</section>

<section id="how-it-works" class="container landing-section">
    <div class="section-heading">
        <span class="eyebrow">How it works</span>
        <h2>A simple workflow from exploration to supervision.</h2>
        <p class="meta">
            The product experience is intentionally direct: discover, apply, then follow progress with the right role in control.
        </p>
    </div>
    <div class="steps-grid">
        <article class="step-card">
            <span class="step-card__index">1</span>
            <h3>Explore internship offers</h3>
            <p>Students browse curated opportunities, review company details, and find relevant openings quickly.</p>
        </article>
        <article class="step-card">
            <span class="step-card__index">2</span>
            <h3>Apply through one platform</h3>
            <p>Applications and documents are submitted in a single workflow with controlled access and clear status.</p>
        </article>
        <article class="step-card">
            <span class="step-card__index">3</span>
            <h3>Track and supervise progress</h3>
            <p>Students monitor their submissions while coordinators follow activity from dedicated dashboards.</p>
        </article>
    </div>
</section>

<section class="container landing-section">
    <div class="workflow-band">
        <div class="section-heading section-heading--compact">
            <span class="eyebrow">Workflow preview</span>
            <h2>A clearer workflow from discovery to follow-up.</h2>
        </div>
        <div class="workflow-track" aria-label="Flux produit">
            <article class="workflow-node">
                <span>Offers</span>
                <p>Searchable internship opportunities with structured details.</p>
            </article>
            <article class="workflow-node">
                <span>Companies</span>
                <p>Public company profiles connected to published opportunities.</p>
            </article>
            <article class="workflow-node">
                <span>Applications</span>
                <p>Documents, submission status, and student tracking in one flow.</p>
            </article>
            <article class="workflow-node">
                <span>Dashboards</span>
                <p>Role-based views for students, coordinators, and administrators.</p>
            </article>
        </div>
    </div>
</section>

<section class="container landing-section">
    <div class="final-cta">
        <div>
            <span class="eyebrow">Ready to start</span>
            <h2>Ready to explore internship opportunities more clearly?</h2>
            <p class="meta">
                InternHub helps students and coordinators work from the same structured platform, from offer discovery to follow-up.
            </p>
        </div>
        <div class="hero__actions">
            <a class="button button--primary" href="<?= e(url('/offres')) ?>">Explore internships</a>
            <?php if (! empty($user)): ?>
                <a class="button button--secondary" href="<?= e(url(match ($user['role']) {
                    'etudiant' => '/dashboard/etudiant',
                    'pilote' => '/dashboard/pilote',
                    'administrateur' => '/dashboard/admin',
                    default => '/',
                })) ?>">Open my space</a>
            <?php else: ?>
                <a class="button button--secondary" href="<?= e(url('/login')) ?>">Sign in</a>
            <?php endif; ?>
        </div>
    </div>
</section>
