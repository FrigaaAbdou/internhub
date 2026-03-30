# P8.7 Verification de phase

Ce document clot `P8` avec un protocole unique de verification.

L objectif etait de sortir d une validation diffusee entre plusieurs commandes et de fournir une porte d entree simple pour rejouer toute la phase.

## 1. Entree unique

Commande de cloture de phase :

- `bash tests/smoke/p8_http_smoke.sh`

## 2. Ce que le script rejoue

Le script de phase `P8` verifie :

- lint PHP sur les fichiers partages modifies pendant `P8`,
- socle unitaire `PHPUnit`,
- smoke test complet `P6`,
- smoke test complet `P7`,
- controles HTTP specifiques `P8`.

Les controles `P8` portent explicitement sur :

- la presence des metas HTML sur l accueil,
- la page publique `/mentions-legales`,
- les metas dynamiques d une page detail offre,
- le retrait de `Health` de la navigation principale,
- la disponibilite du lien `Mentions legales` en footer.

## 3. Resultat attendu

La phase `P8` est consideree comme valide si :

- `PHPUnit` reste vert,
- les suites `P6` et `P7` repassent integralement,
- les ajustements de stabilisation `P8.5` et `P8.6` restent visibles en runtime,
- aucun regressif evident n apparait sur les points partages.

## 4. Resultat de la verification

Execution de reference :

- `bash tests/smoke/p8_http_smoke.sh`

Sortie attendue :

- `P8 smoke test passed.`

## 5. Conclusion de phase

Avec cette verification, `P8` dispose maintenant :

- d un audit documente,
- d un socle unitaire minimal,
- d une verification responsive et accessibilite pratique,
- d un lot de hygiene finale,
- d une validation de phase rejouable en une commande.

La prochaine phase logique est `P9`.
