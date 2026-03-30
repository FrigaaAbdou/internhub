# Stabilisation P8.3 - erreurs et experience de repli

Ce document formalise la revue `P8.3`.

Il se concentre sur :

- les pages `403`, `404`, `500`,
- la gestion globale des exceptions,
- les messages flash,
- les redirects de repli,
- les etats vides ou pauvres sur les ecrans de gestion.

## 1. Socle actuel

Le comportement de repli est centralise dans [App.php](/Users/abdoufrigaa/Projects/internhub/app/Core/App.php#L22).

Constats positifs :

- les `HttpException` sont converties proprement en pages `403` ou `404`,
- les erreurs non prevues sont loggees dans `storage/logs/app.log`,
- la page `500` masque le detail en prod et ne l expose qu en `debug`,
- les messages flash sont rendus globalement dans le layout via [flash.php](/Users/abdoufrigaa/Projects/internhub/app/Views/partials/flash.php#L1),
- les routes protegees anonymes redirigent vers `/login` avec message utilisateur.

Base deja saine :

- [App.php](/Users/abdoufrigaa/Projects/internhub/app/Core/App.php#L22)
- [AuthenticateMiddleware.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Middleware/AuthenticateMiddleware.php#L12)
- [EnsureRoleMiddleware.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Middleware/EnsureRoleMiddleware.php#L14)
- [layouts/app.php](/Users/abdoufrigaa/Projects/internhub/app/Views/layouts/app.php#L1)

## 2. Ce qui est deja stabilise

### 2.1 Pages erreur dediees

Les trois pages existent :

- [403.php](/Users/abdoufrigaa/Projects/internhub/app/Views/errors/403.php#L1)
- [404.php](/Users/abdoufrigaa/Projects/internhub/app/Views/errors/404.php#L1)
- [500.php](/Users/abdoufrigaa/Projects/internhub/app/Views/errors/500.php#L1)

Elles ont deja :

- un titre clair,
- un message lisible,
- un code erreur affiche,
- un CTA de retour.

### 2.2 Flash global

Le layout applique deja un point d entree unique pour les retours utilisateur :

- succes via `role="status"`,
- erreur via `role="alert"`.

Cela evite la dispersion des messages dans les vues.

### 2.3 Repli nominal sur de nombreux cas limites

Le produit repli deja proprement sur plusieurs cas :

- demande de login sur route protegee,
- candidature en doublon,
- wish-list deja existante,
- suppression bloquee si dependances,
- ressources inexistantes en consultation publique ou privee.

## 3. Ecarts constates

### Priorite 1

#### R1. Les pages `403`, `404`, `500` proposent un seul retour generique

Constat :

- les trois pages renvoient seulement vers l accueil dans [403.php](/Users/abdoufrigaa/Projects/internhub/app/Views/errors/403.php#L1), [404.php](/Users/abdoufrigaa/Projects/internhub/app/Views/errors/404.php#L1) et [500.php](/Users/abdoufrigaa/Projects/internhub/app/Views/errors/500.php#L1).

Risque :

- repli trop pauvre pour un utilisateur connecte,
- perte de contexte apres une erreur depuis un espace role,
- impression de produit peu fini en soutenance.

Stabilisation attendue :

- ajouter au moins un retour contextuel secondaire :
  - vers `/dashboard/etudiant` si etudiant,
  - vers `/dashboard/pilote` si pilote,
  - vers `/dashboard/admin` si admin,
  - vers `/login` si anonyme dans certains cas pertinents.

#### R2. Plusieurs ecrans de gestion n ont pas de vrai vide fonctionnel

Constat :

- [accounts.php](/Users/abdoufrigaa/Projects/internhub/app/Views/admin/accounts.php#L1),
- [students.php](/Users/abdoufrigaa/Projects/internhub/app/Views/pilot/students.php#L1),
- [manage.php](/Users/abdoufrigaa/Projects/internhub/app/Views/offers/manage.php#L1),
- [manage.php](/Users/abdoufrigaa/Projects/internhub/app/Views/companies/manage.php#L1)

affichent directement un tableau, meme si la liste est vide ou si la recherche ne retourne rien.

Risque :

- ecrans visuellement vides,
- absence de guidance sur l action suivante,
- faible lisibilite apres filtrage ou premiere utilisation.

Stabilisation attendue :

- ajouter un etat vide explicite,
- proposer une action concrete :
  - creer un compte,
  - creer une entreprise,
  - creer une offre,
  - retirer un filtre.

### Priorite 2

#### R3. Le titre HTML reste statique sur toutes les pages

Constat :

- [layouts/app.php](/Users/abdoufrigaa/Projects/internhub/app/Views/layouts/app.php#L1) utilise seulement le nom applicatif comme `<title>`.

Risque :

- experience de navigation faible,
- erreurs et ecrans de gestion peu differencies,
- moins bonne lisibilite navigateur.

Lecture :

- c est aussi un sujet `P8.6`,
- mais il participe au repli global sur les pages d erreur.

#### R4. Les redirects de repli restent surtout centraux, peu contextualises

Constat :

- beaucoup de controllers redirigent vers une liste ou un dashboard,
- mais peu de messages distinguent :
  - erreur fonctionnelle,
  - absence de droit,
  - action deja realisee,
  - absence de resultat apres filtre.

Risque :

- repli correct techniquement,
- mais encore pauvre en lisibilite produit.

Stabilisation attendue :

- uniformiser les messages sur les cas de blocage,
- expliciter les retours apres action impossible ou inutile.

### Priorite 3

#### R5. `EnsureRoleMiddleware` suppose une composition correcte avec `AuthenticateMiddleware`

Constat :

- [EnsureRoleMiddleware.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Middleware/EnsureRoleMiddleware.php#L14) sait aussi rediriger vers `/login` si l utilisateur n est pas connecte,
- mais sans enregistrer `auth.intended` ni flasher de message, contrairement a [AuthenticateMiddleware.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Middleware/AuthenticateMiddleware.php#L12).

Lecture :

- ce n est pas un bug sur l etat actuel, car les routes protegees sont bien composees,
- c est un point de fragilite structurelle si une future route oublie `AuthenticateMiddleware`.

Stabilisation attendue :

- documenter l ordre obligatoire des middleware,
- ou fusionner le comportement de repli.

## 4. Etats de repli deja bons par vue

Vues avec etat vide correct :

- [index.php](/Users/abdoufrigaa/Projects/internhub/app/Views/offers/index.php#L1)
- [index.php](/Users/abdoufrigaa/Projects/internhub/app/Views/companies/index.php#L1)
- [applications.php](/Users/abdoufrigaa/Projects/internhub/app/Views/student/applications.php#L1)
- [wishlist.php](/Users/abdoufrigaa/Projects/internhub/app/Views/student/wishlist.php#L1)
- [student-applications.php](/Users/abdoufrigaa/Projects/internhub/app/Views/pilot/student-applications.php#L1)
- [show-student.php](/Users/abdoufrigaa/Projects/internhub/app/Views/pilot/show-student.php#L1)
- [dashboard.php](/Users/abdoufrigaa/Projects/internhub/app/Views/pilot/dashboard.php#L1)
- [dashboard.php](/Users/abdoufrigaa/Projects/internhub/app/Views/student/dashboard.php#L1)

Vues a completer :

- [accounts.php](/Users/abdoufrigaa/Projects/internhub/app/Views/admin/accounts.php#L1)
- [students.php](/Users/abdoufrigaa/Projects/internhub/app/Views/pilot/students.php#L1)
- [manage.php](/Users/abdoufrigaa/Projects/internhub/app/Views/offers/manage.php#L1)
- [manage.php](/Users/abdoufrigaa/Projects/internhub/app/Views/companies/manage.php#L1)

## 5. Arbitrage de sortie pour P8.3

Lecture globale :

- le produit n a pas de faiblesse majeure sur le traitement des erreurs,
- la base technique de repli est propre,
- le vrai travail de `P8.3` est surtout qualitatif et contextuel.

Ordre recommande :

1. enrichir les pages `403`, `404`, `500` avec des retours plus utiles,
2. ajouter les etats vides manquants sur les vues de gestion,
3. harmoniser les messages de repli sur les actions bloquees,
4. traiter les titres HTML dynamiques au plus tard avec `P8.6`.

## 6. Prochaine action

Passer a `P8.4 Socle de tests automatise minimal`, ou choisir de corriger d abord `R1` et `R2` pour fermer les ecarts les plus visibles avant d introduire de nouveaux tests.
