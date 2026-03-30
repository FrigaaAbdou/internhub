# Plan de phase P8

Ce document fixe un plan d execution court et concret pour `P8. Stabilisation`.

Il part de l etat reel du repo :

- `P5`, `P6` et `P7` sont implementes et verifies par smoke tests,
- les modules coeur et avances sont en place,
- la couverture actuelle repose surtout sur des verifications HTTP de bout en bout,
- il n y a pas encore de socle `Composer` / `PHPUnit`,
- la phase suivante doit fiabiliser, durcir et preparer la version de demo.

## 1. Objectif de la phase

Amener l application a un niveau de fiabilite defendable en soutenance et exploitable comme base de livraison :

- validations coherentes,
- securite de base revue,
- droits controles sans ambiguite,
- erreurs et cas limites propres,
- lot minimal de tests automatise plus solide,
- responsive et meta de base verifies.

## 2. Ordre d execution recommande

### P8.1 Audit de validation et de securite

Passer en revue tous les formulaires et points sensibles :

- login,
- creation et edition de comptes,
- creation et edition d offres,
- creation et edition d entreprises,
- candidature,
- wish-list,
- profil etudiant.

Verifier pour chaque point :

- validation serveur complete,
- messages d erreur coherents,
- presence des protections `CSRF`,
- blocage des donnees incoherentes ou vides,
- normalisation minimale des donnees saisies.

Sortie attendue :
une matrice claire des formulaires, gardes et corrections prioritaires a appliquer.

### P8.2 Revue complete des droits et cas limites

Rejouer systematiquement les droits selon la matrice et les parcours reels :

- anonyme,
- etudiant,
- pilote,
- administrateur.

Verifier aussi les cas limites fonctionnels :

- deja postule,
- offre inexistante,
- entreprise inexistante,
- compte non autorise,
- etudiant hors promotion,
- tentative d acces a un brouillon,
- suppression bloquee par des dependances.

Sortie attendue :
les routes critiques sont confirmees ou corrigees, sans trou d autorisation.

### P8.3 Stabilisation des erreurs et de l experience de repli

Revoir les ecrans et comportements de repli :

- `403`,
- `404`,
- `500`,
- redirects post action,
- messages flash succes / erreur,
- cas sans donnees,
- retours apres formulaire invalide.

Sortie attendue :
l application reste lisible et propre meme en sortie de flux nominal.

### P8.4 Socle de tests automatise minimal

Ajouter le minimum necessaire pour sortir du tout-smoke :

- initialiser `Composer` si absent,
- ajouter `PHPUnit`,
- couvrir les points unitaires les plus rentables,
- garder les smoke tests HTTP comme filet d integration.

Priorite de couverture :

- helpers et utilitaires critiques,
- validation metier simple,
- gardes ou regles sensibles faciles a tester,
- non-regression sur les modules les plus exposes.

Sortie attendue :
un premier lot de tests unitaires reproductibles, execute en plus des smoke tests.

### P8.5 Responsive, accessibilite pratique et performance legere

Verifier les pages critiques en conditions reelles :

- accueil,
- login,
- liste d offres,
- detail offre,
- candidature,
- dashboard etudiant,
- dashboard pilote,
- liste et gestion admin.

Contrôles attendus :

- lisibilite mobile,
- actions tactiles utilisables,
- tableaux et formulaires utilisables en petit ecran,
- absence de rupture evidente,
- requetes et rendu corrects sur les pages les plus chargees.

Sortie attendue :
les parcours principaux restent solides sur mobile et ne montrent pas de faiblesse evidente de performance.

### P8.6 Mentions legales, meta et hygiene finale

Ajouter le lot minimal de finition technique :

- mentions legales de base,
- meta `title` et `description` minimales,
- verifications finales sur `health`, headers essentiels et structure HTML,
- nettoyage des incoherences de navigation ou libelles restants.

Sortie attendue :
une application plus propre, plus presentable et moins fragile avant `P9`.

### P8.7 Verification de phase

Clore `P8` avec une verification complete :

- lint PHP,
- suite smoke `P6`,
- suite smoke `P7`,
- nouveau lot de verifications `P8`,
- execution du lot unitaire minimal si le socle a ete ajoute,
- controle final des pages critiques et cas limites corriges.

Sortie attendue :
`P8` validable sur un protocole unique, pas sur une accumulation de verifications implicites.

## 3. Definition of Done

`P8` pourra etre consideree comme terminee si :

- les formulaires critiques ont ete revus et corriges si necessaire,
- les protections `CSRF` et les droits par role ont ete verifies globalement,
- les principaux cas limites connus sont couverts,
- un lot minimal de tests unitaires existe si le socle `Composer` / `PHPUnit` est introduit,
- les smoke tests `P6` et `P7` passent encore,
- le responsive et les meta de base ont ete controles,
- un smoke test ou protocole `P8` unique permet de rejouer la phase.

## 4. Prochaine action

Commencer par `P8.1 Audit de validation et de securite`.
