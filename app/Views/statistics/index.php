<?php

declare(strict_types=1);
?>
<section class="container detail-shell">
    <div class="panel dashboard-shell">
        <p class="eyebrow">Statistiques</p>
        <h1>Vue d ensemble des offres</h1>
        <p class="lead">
            Ces indicateurs sont globaux et anonymises. Ils permettent de suivre l activite de la plateforme
            sans exposer d informations individuelles sur les etudiants ou les recruteurs.
        </p>

        <div class="stats-grid">
            <article class="panel stat-card">
                <p class="meta">Offres publiees</p>
                <strong><?= e((string) $publishedOfferCount) ?></strong>
            </article>
            <article class="panel stat-card">
                <p class="meta">Entreprises referencees</p>
                <strong><?= e((string) $companyCount) ?></strong>
            </article>
            <article class="panel stat-card">
                <p class="meta">Candidatures deposees</p>
                <strong><?= e((string) $applicationCount) ?></strong>
            </article>
            <article class="panel stat-card">
                <p class="meta">Moyenne candidatures / offre</p>
                <strong><?= e(number_format((float) $averageApplicationsPerOffer, 1, ',', ' ')) ?></strong>
            </article>
        </div>

        <div class="subsection">
            <h2>Indicateurs exploitables</h2>
            <div class="card-grid">
                <article class="panel">
                    <h3>Offres par ville</h3>
                    <?php if ($topLocations === []): ?>
                        <p class="meta">Aucune offre publiee pour le moment.</p>
                    <?php else: ?>
                        <ul class="metric-list">
                            <?php foreach ($topLocations as $location): ?>
                                <li>
                                    <span><?= e((string) $location['label']) ?></span>
                                    <strong><?= e((string) $location['total']) ?></strong>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </article>

                <article class="panel">
                    <h3>Offres par type de contrat</h3>
                    <?php if ($topContractTypes === []): ?>
                        <p class="meta">Aucun type de contrat disponible pour le moment.</p>
                    <?php else: ?>
                        <ul class="metric-list">
                            <?php foreach ($topContractTypes as $contractType): ?>
                                <li>
                                    <span><?= e((string) $contractType['label']) ?></span>
                                    <strong><?= e((string) $contractType['total']) ?></strong>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </article>
            </div>
        </div>

        <div class="subsection">
            <h2>Repartition des candidatures</h2>
            <?php if ($applicationStatuses === []): ?>
                <p class="meta">Aucune candidature enregistree pour le moment.</p>
            <?php else: ?>
                <ul class="metric-list">
                    <?php foreach ($applicationStatuses as $status): ?>
                        <li>
                            <span><?= e(ucfirst((string) $status['label'])) ?></span>
                            <strong><?= e((string) $status['total']) ?></strong>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
