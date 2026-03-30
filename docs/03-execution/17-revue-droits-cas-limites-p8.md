# Revue P8.2 - droits et cas limites

Ce document formalise la revue `P8.2`.

Il croise :

- la matrice source de verite [Matrice_permissions_2025_V2_1.json](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/permissions/Matrice_permissions_2025_V2_1.json),
- la synthese projet [04-roles-et-permissions.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/04-roles-et-permissions.md),
- les routes reelles [routes.php](/Users/abdoufrigaa/Projects/internhub/config/routes.php),
- les middleware d acces [AuthenticateMiddleware.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Middleware/AuthenticateMiddleware.php) et [EnsureRoleMiddleware.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Middleware/EnsureRoleMiddleware.php),
- la couverture smoke existante dans `tests/smoke/`.

## 1. Regle de lecture

La matrice JSON reste la source de verite fonctionnelle.

Traduction de comportement attendue :

- utilisateur anonyme sur route protegee : redirection vers `/login`,
- utilisateur authentifie mais sans droit : `403`,
- ressource inexistante ou brouillon non public : `404`,
- controles fins de perimetre pilote : `403` hors promotion.

Ces comportements sont coherents avec :

- [AuthenticateMiddleware.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Middleware/AuthenticateMiddleware.php#L12),
- [EnsureRoleMiddleware.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Middleware/EnsureRoleMiddleware.php#L14).

## 2. Alignement global des droits

### Anonyme

Acces conformes a la matrice :

- `/login`
- `/offres`
- `/offres/{id}` si offre publiee
- `/entreprises`
- `/entreprises/{id}`
- `/statistiques`

Refus attendus :

- toutes les routes `/dashboard/*`
- toutes les routes `/admin/*`
- toutes les actions `POST` etudiantes, pilote ou admin

### Etudiant

Acces conformes a la matrice :

- consultation publique des offres et entreprises,
- `/dashboard/etudiant`
- `/dashboard/etudiant/candidatures`
- `/dashboard/etudiant/candidatures/{id}`
- `/dashboard/etudiant/candidatures/{id}/cv`
- `/offres/{id}/postuler`
- wish-list,
- `/statistiques`

Refus attendus :

- routes pilote,
- routes admin,
- consultation des donnees d un autre etudiant,
- consultation des candidatures d une promo pilote.

### Pilote

Acces conformes a la matrice :

- consultation publique,
- `/dashboard/pilote`
- gestion entreprises,
- gestion offres,
- gestion comptes etudiants,
- supervision des candidatures de sa promotion,
- `/statistiques`

Refus attendus :

- gestion de comptes pilotes,
- parcours personnels etudiants,
- wish-list,
- candidatures hors promotion.

### Administrateur

Acces conformes a la matrice :

- consultation publique,
- `/dashboard/admin`
- gestion comptes `pilote` et `etudiant`,
- gestion entreprises,
- gestion offres,
- `/statistiques`

Refus attendus :

- postuler,
- wish-list,
- parcours personnels etudiants,
- supervision pilote de promotion.

## 3. Correspondance matrice -> routes

| Code | Droit matrice | Implementation constatee | Etat |
| --- | --- | --- | --- |
| `SFx1` | Authentification | `/login`, `/logout`, middleware auth | Aligne |
| `SFx2` | Voir entreprises | `/entreprises`, `/entreprises/{id}` | Aligne |
| `SFx3` a `SFx6` | CRUD entreprises | `/admin/entreprises*`, `/dashboard/pilote/entreprises*` | Aligne pour `create/edit/delete`; `SFx5` evaluation non implementee |
| `SFx7` | Voir offres | `/offres`, `/offres/{id}` | Aligne |
| `SFx8` a `SFx10` | CRUD offres | `/admin/offres*`, `/dashboard/pilote/offres*` | Aligne |
| `SFx11` | Statistiques | `/statistiques` public | Aligne |
| `SFx12` a `SFx15` | Comptes pilotes | gere via `/admin/comptes*` | Aligne fonctionnellement |
| `SFx16` a `SFx19` | Comptes etudiants | `/admin/comptes*`, `/dashboard/pilote/etudiants*` | Aligne |
| `SFx20` | Postuler | `/offres/{id}/postuler` | Aligne |
| `SFx21` | Voir ses candidatures | `/dashboard/etudiant/candidatures*` | Aligne |
| `SFx22` | Voir candidatures de la promo | `/dashboard/pilote/etudiants/{id}/candidatures`, `/dashboard/pilote/candidatures/{id}` | Aligne |
| `SFx23` a `SFx25` | Wish-list | routes `/wishlist` et `POST` associes | Aligne |

## 4. Points confirmes par les tests existants

Les smoke tests actuels confirment deja une partie importante de la revue :

- `403` etudiant vers routes admin et pilote dans [p6_http_smoke.sh](/Users/abdoufrigaa/Projects/internhub/tests/smoke/p6_http_smoke.sh#L1),
- `403` admin vers dashboard pilote dans [p6_http_smoke.sh](/Users/abdoufrigaa/Projects/internhub/tests/smoke/p6_http_smoke.sh#L1),
- blocage suppression entreprise avec offres et suppression offre avec candidatures dans [p6_http_smoke.sh](/Users/abdoufrigaa/Projects/internhub/tests/smoke/p6_http_smoke.sh#L1),
- acces pilote hors promotion refuse dans [p7_candidatures_smoke.sh](/Users/abdoufrigaa/Projects/internhub/tests/smoke/p7_candidatures_smoke.sh#L1) et [p7_pilot_followup_smoke.sh](/Users/abdoufrigaa/Projects/internhub/tests/smoke/p7_pilot_followup_smoke.sh#L1),
- statistiques publiques et par role confirmees dans [p7_statistics_smoke.sh](/Users/abdoufrigaa/Projects/internhub/tests/smoke/p7_statistics_smoke.sh#L1),
- profil etudiant reserve a l etudiant connecte dans [p7_student_profile_smoke.sh](/Users/abdoufrigaa/Projects/internhub/tests/smoke/p7_student_profile_smoke.sh#L1).

## 5. Cas limites deja bien traites

Cas limites actuellement bien couverts ou deja implementes proprement :

- offre inexistante : `404`,
- offre brouillon cote public : `404`,
- candidature en doublon : blocage et message utilisateur,
- wish-list en doublon : blocage doux sans duplication,
- suppression entreprise avec offres : blocage,
- suppression offre avec candidatures : blocage,
- candidature ou etudiant hors promotion cote pilote : `403`,
- candidature inexistante : `404`,
- route protegee anonyme : redirection `/login`.

## 6. Cas limites encore partiels ou non verifies explicitement

### Priorite 1

#### C1. Refus explicite des parcours etudiants personnels pour `Administrateur`

Constat :

- la matrice interdit les usages personnels etudiants a l admin,
- le test de phase ne couvre pas encore explicitement :
  - `/dashboard/etudiant/candidatures`
  - `/dashboard/etudiant/wishlist`
  - `/offres/{id}/postuler`
  - `/dashboard/etudiant/profil`

Attendu :

- `403` pour un admin connecte.

#### C2. Refus explicite des parcours etudiants personnels pour `Pilote`

Constat :

- la matrice interdit wish-list, candidature et profil personnel etudiant au pilote,
- ces refus ne sont pas encore verifies de facon centralisee.

Attendu :

- `403` pour un pilote connecte sur :
  - `/dashboard/etudiant/*`
  - `/offres/{id}/postuler`
  - wish-list `POST`.

#### C3. Refus explicite des routes admin de comptes pilotes pour `Pilote`

Constat :

- la matrice reserve `SFx12` a `SFx15` a l admin,
- le pilote ne doit pas pouvoir utiliser `/admin/comptes` pour se rapprocher de la gestion des pilotes,
- les tests actuels couvrent surtout les espaces pilote et etudiant, moins cette zone precise.

Attendu :

- `403` sur `/admin/comptes` et sur les variations `create/edit/delete` pour un pilote connecte.

### Priorite 2

#### C4. Cas anonymes `POST` sur actions protegees

Constat :

- le middleware redirige correctement vers `/login`,
- mais les scripts couvrent surtout les `GET` anonymes et les `POST` authentifies.

Attendu :

- redirection propre vers `/login` pour :
  - ajout wish-list,
  - retrait wish-list,
  - candidature,
  - creation offre,
  - creation entreprise,
  - creation compte.

#### C5. Cas de ressources inexistantes sur routes d edition protegees

Constat :

- les controllers utilisent globalement `404`,
- mais les tests de phase ne rejouent pas encore de facon systematique :
  - offre inexistante en edition,
  - entreprise inexistante en edition,
  - compte inexistant en edition.

Attendu :

- `404` ou `403` selon la ressource et le perimetre, sans fuite de donnees.

### Priorite 3

#### C6. Fonction `SFx5` non implementee

Constat :

- la matrice declare `Evaluer une entreprise` autorise pour admin et pilote,
- l application ne propose actuellement pas ce module.

Lecture correcte :

- ce n est pas une faille de droit,
- c est un ecart de couverture fonctionnelle a garder visible avant soutenance.

## 7. Conclusion de revue

Lecture globale :

- l alignement des droits principaux avec la matrice est bon,
- les comportements d acces sont coherents entre middleware et modules metier,
- les trous restants sont surtout des verifications explicites manquantes, pas des contradictions evidentes.

Le point le plus important pour la suite de `P8` :

- transformer les cas `C1` a `C5` en checks automatises ou en smoke `P8`, afin de figer les droits avant la phase de soutenance.

## 8. Prochaine action

Passer a `P8.3 Stabilisation des erreurs et de l experience de repli`, ou creer d abord un smoke test `P8` qui formalise les cas `C1` a `C5`.
