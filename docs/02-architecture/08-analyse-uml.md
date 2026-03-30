# Analyse du dossier UML

Ce document synthétise l'architecture déduite des fichiers présents dans `docs/05-sources/uml`.

## 1. Fichiers analysés

| Fichier | Type | Ce qu'il apporte |
| --- | --- | --- |
| `Page Map - Plateforme Stages (Site Map).png` | Site map | structure des routes, espaces par rôle, pages d'erreur |
| `Stage platform - User flow (Etudiant - Recherche -> Postuler).png` | User flow | parcours simple de recherche vers candidature |
| `User Journey - Étudiant - Rechercher -> Postuler (CV+LM).png` | User journey | parcours détaillé étudiant avec cas d'erreur |
| `title User Journey .png` | User journey | parcours pilote pour le suivi des candidatures |
| `Sequence - Login Student (Auth).png` | Séquence | mécanisme d'authentification étudiant |
| `Sequence - Recherche Offres.png` | Séquence | recherche d'offres avec filtres et pagination |
| `Sequence - Wish-list (Ajouter).png` | Séquence | ajout d'une offre à la wish-list |
| `Sequence - Postuler a une offre (CV+LM).png` | Séquence | candidature avec LM, CV et stockage de fichier |
| `XPFDJjj04CVl-...png` | Use case | vue fonctionnelle globale par rôle |

## 2. Vue d'ensemble de l'architecture

L'architecture montrée dans les diagrammes est une architecture web en couches, proche d'un MVC enrichi :

- `Browser` envoie la requête HTTP.
- `Router` résout la route.
- `Controller` orchestre le cas d'usage.
- `Middleware` applique l'authentification et les rôles quand nécessaire.
- `CsrfService` valide les formulaires sensibles.
- `Service` porte la logique métier.
- `Repository` ou accès direct DB porte la logique d'accès aux données.
- `View` rend la réponse HTML.
- `Session` gère l'état d'authentification.
- `Storage` gère les fichiers uploadés, surtout les CV.

Conclusion :
le projet ne se limite pas à un MVC minimal. Les UML décrivent déjà une séparation en `Controller -> Service -> Repository/DB`, avec middleware de sécurité et gestion de fichiers.

## 3. Architecture technique déduite

### 3.1 Couche HTTP

Les séquences montrent un point d'entrée de type :

- `GET /login`
- `POST /login`
- `GET /offres`
- `GET /offres/{id}`
- `GET /offres/{id}/postuler`
- `POST /offres/{id}/postuler`
- `POST /wishlist`

Le `Router` distribue ensuite la requête vers le bon contrôleur.

### 3.2 Contrôleurs identifiés

Les diagrammes font apparaître directement ou implicitement :

- `AuthController`
- `OffreController`
- `CandidatureController`
- `WishlistController`

Le site map et les parcours impliquent aussi des contrôleurs ou modules supplémentaires :

- gestion des entreprises,
- gestion des comptes,
- dashboard admin,
- dashboard pilote,
- dashboard étudiant,
- statistiques.

### 3.3 Services identifiés

Les services explicitement montrés sont :

- `AuthService`
- `CsrfService`
- `WishlistService`
- `UploadService`
- `CandidatureService`

Le diagramme de recherche montre aussi une séparation via `OffreRepository`, ce qui suggère qu'une logique métier et une logique de persistance sont déjà pensées comme distinctes.

### 3.4 Persistance

Les séquences montrent deux types de persistance :

- `DB` pour les données relationnelles,
- `Storage` pour les fichiers uploadés.

Cela implique déjà une distinction importante :

- les CV ne doivent pas être stockés directement dans la base,
- la base stocke plutôt le chemin du fichier, ses métadonnées et les références de candidature.

## 4. Architecture fonctionnelle par rôle

### 4.1 Visiteur

Le visiteur peut :

- accéder à la landing page,
- consulter `about`,
- rechercher et consulter des offres,
- consulter des entreprises,
- voir des statistiques,
- être redirigé vers `login` ou `register` selon le besoin.

### 4.2 Étudiant

L'étudiant peut :

- consulter les offres,
- consulter une offre en détail,
- postuler à une offre,
- gérer sa wish-list,
- consulter ses candidatures,
- consulter son profil,
- télécharger son CV déjà soumis.

Les diagrammes montrent clairement que l'étudiant est au coeur du produit.

### 4.3 Pilote

Le pilote peut :

- accéder à un dashboard dédié,
- lister les étudiants de sa promo,
- consulter les candidatures d'un étudiant,
- télécharger les CV/LM des étudiants de sa promo,
- être bloqué par une règle de promotion si l'étudiant n'appartient pas à sa promo.

### 4.4 Admin

L'admin peut :

- gérer les entreprises,
- gérer les offres,
- gérer les comptes,
- consulter les statistiques,
- accéder au dashboard admin.

## 5. Domaines métier identifiés

Les UML laissent apparaître les objets métier suivants :

- `User`
- `Student`
- `Pilot`
- `Admin`
- `Promo`
- `Company`
- `Offer`
- `Skill`
- `Application` ou `Candidature`
- `WishlistItem`
- `Session`
- `UploadedFile`

Relations probables :

- une `Offer` appartient à une `Company`,
- une `Offer` est liée à plusieurs `Skill`,
- un `Student` peut avoir plusieurs `Application`,
- un `Student` peut avoir plusieurs éléments de `Wishlist`,
- un `Pilot` suit une ou plusieurs promos,
- un `Student` appartient à une promo,
- une `Application` relie un étudiant à une offre avec LM, CV et date.

## 6. Parcours principaux confirmés

### 6.1 Recherche d'offres

Le parcours est :

- ouverture de `/offres` avec paramètres de recherche,
- exécution d'une recherche côté repository,
- jointures avec entreprise et compétences,
- pagination via `LIMIT/OFFSET`,
- rendu HTML de la liste.

Cela confirme que la recherche n'est pas un simple filtrage en front, mais bien un traitement serveur.

### 6.2 Authentification étudiant

Le login suit cette logique :

- ouverture de `/login`,
- génération d'un token CSRF,
- soumission email + mot de passe + token,
- validation CSRF,
- vérification des identifiants via `AuthService`,
- lecture base par email,
- création de session avec `user_id`, `role`, `promo_id`,
- cookie de session sécurisé.

Le diagramme mentionne explicitement :

- `HttpOnly`
- `Secure`
- `SameSite`

Donc la sécurité de session est déjà un élément d'architecture attendu.

### 6.3 Candidature

Le parcours candidature est le plus riche du dossier UML.

Il montre :

- accès au détail d'offre,
- clic sur `Postuler`,
- contrôle de rôle étudiant,
- éventuelle redirection vers login,
- génération d'un formulaire avec token CSRF,
- vérification que l'offre existe,
- soumission LM + CV + token,
- validation CSRF,
- contrôle d'unicité de candidature,
- sauvegarde du PDF dans `Storage`,
- insertion en base avec chemin du fichier,
- redirection vers le dashboard étudiant.

Architecture déduite :

- la candidature est un vrai cas d'usage métier,
- il faut un service dédié,
- il faut une gestion d'erreurs fonctionnelles et techniques,
- la contrainte "déjà postulé" fait partie du métier.

### 6.4 Wish-list

Le flux d'ajout à la wish-list confirme :

- contrôle d'authentification obligatoire,
- contrôle CSRF,
- test d'existence en base,
- comportement idempotent si déjà présent,
- redirection avec message flash.

Conclusion :
la wish-list n'est pas juste une table annexe. Elle fait partie du parcours utilisateur normal et mérite un traitement métier propre.

## 7. Règles métier visibles dans les UML

Les diagrammes contiennent déjà plusieurs règles importantes :

- un étudiant ne peut pas créer lui-même son compte,
- certaines routes exigent strictement le rôle `ETUDIANT`,
- le pilote ne peut télécharger les documents que si l'étudiant appartient à sa promo,
- une candidature ne doit pas pouvoir être créée deux fois pour la même offre,
- la wish-list ne doit pas créer de doublon,
- un formulaire sensible doit toujours être protégé par CSRF.

## 8. Structure de routes déduite

Le site map montre une structuration claire des routes :

### Public

- `/`
- `/landing`
- `/about`
- `/offres`
- `/offres/{id}`
- `/entreprises`
- `/entreprises/{id}`
- `/login`
- `/register`

### Étudiant

- `/dashboard/etudiant`
- `/profil`
- `/profil/edit`
- `/offres/{id}/postuler`
- `/dashboard/etudiant/candidatures`
- `/candidatures/{id}`
- `/candidatures/{id}/cv`
- `/dashboard/etudiant/wishlist`
- `/logout`

### Pilote

- `/dashboard/pilote`
- `/dashboard/pilote/etudiants`
- `/dashboard/pilote/etudiants/{id}`
- `/dashboard/pilote/etudiants/{id}/candidatures`
- `/pilote/candidatures/{id}/cv`

### Admin

- `/dashboard/admin`
- `/admin/entreprises`
- `/admin/entreprises/create`
- `/admin/entreprises/{id}/edit`
- `/admin/offres`
- `/admin/offres/create`
- `/admin/offres/{id}/edit`
- `/admin/comptes`
- `/admin/comptes/create`
- `/admin/comptes/{id}/edit`
- `/admin/stats`

### Erreurs

- `403 Forbidden`
- `404 Not Found`
- `500 Server Error`

## 9. Incohérences ou points à clarifier

### 9.1 Register étudiant

Le site map montre une route `/register`, mais plusieurs diagrammes précisent que l'étudiant a déjà un compte créé par l'administration et ne peut pas se créer lui-même un compte.

Conclusion :
il faut clarifier si `register` est :

- un reste de maquette,
- une création de compte publique pour un autre rôle,
- ou une route à supprimer.

### 9.2 Repository partiel

Le diagramme de recherche montre `OffreRepository`, mais les autres séquences passent souvent par `Service -> DB` sans repository explicite.

Conclusion :
il faut choisir une convention homogène :

- soit service + repository,
- soit controller + service + repository partout,
- soit repository seulement pour certains domaines avec justification.

### 9.3 Nommage des routes

Le site map mélange parfois :

- anglais et français,
- `dashboard/etudiant`,
- `admin/comptes`,
- `wishlist`,
- `login`,
- `about`.

Conclusion :
une convention de nommage unique devra être décidée avant implémentation.

## 10. Lecture finale de l'architecture

L'architecture cible comprise à partir du dossier UML est la suivante :

- application serveur rendue côté backend,
- organisation MVC,
- séparation nette entre routage, contrôleurs, services et accès aux données,
- middleware pour auth et rôles,
- service CSRF centralisé,
- stockage de fichiers séparé de la base,
- dashboards distincts par rôle,
- coeur métier centré sur les offres, candidatures, comptes et wish-list.

## 11. Recommandation immédiate

Avant d'implémenter, il serait pertinent de figer maintenant :

- le schéma des routes officielles,
- le modèle de données,
- la politique de rôle et permissions,
- la convention `Controller / Service / Repository`,
- la règle exacte de création des comptes étudiants.
