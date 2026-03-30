<?php

declare(strict_types=1);
?>
<section class="container detail-shell">
    <div class="panel">
        <p class="eyebrow">Cadre legal</p>
        <h1>Mentions legales</h1>
        <p class="lead">
            Cette page formalise le cadre minimal de publication pour la version de demonstration d `<?= e($appName) ?>`.
            Le projet est presente comme une application pedagogique et non comme un service commercial public.
        </p>
    </div>
</section>

<section class="container section-grid">
    <article class="panel" id="about">
        <h2>Editeur</h2>
        <ul class="check-list">
            <li><strong>Nom :</strong> <?= e($publisher) ?></li>
            <li><strong>Responsable de publication :</strong> <?= e($director) ?></li>
            <li><strong>Contact :</strong> <a href="mailto:<?= e($contactEmail) ?>"><?= e($contactEmail) ?></a></li>
        </ul>
    </article>

    <article class="panel">
        <h2>Hebergement</h2>
        <p><?= e($hosting) ?></p>
        <p class="meta">Cette mention reste volontairement sobre car le projet est principalement exploite en environnement local ou de demonstration.</p>
    </article>

    <article class="panel" id="donnees-personnelles">
        <h2>Donnees personnelles</h2>
        <p>
            Les donnees affichees dans cette instance servent a la demonstration technique du projet. Elles ne doivent pas etre
            considerees comme une base de production ni comme un traitement destine a un usage public.
        </p>
        <p>
            Pour une mise en ligne reelle, une politique de confidentialite dediee, un cadre de conservation et des procedures
            de suppression devraient etre ajoutes.
        </p>
    </article>

    <article class="panel">
        <h2>Propriete intellectuelle</h2>
        <p>
            Les contenus, ecrans, structures de navigation et elements applicatifs de cette demonstration restent rattaches au projet
            pedagogique `<?= e($appName) ?>`. Toute reprise dans un cadre public doit etre revue avant diffusion.
        </p>
    </article>
</section>
