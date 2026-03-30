# Architecture MVC de depart

Ce document decrit la structure MVC proposee pour demarrer le projet `InternHub`, sans encore l'implementer dans le depot.

## 1. Objectif

Fournir un socle simple, lisible et maintenable pour :

- respecter la contrainte MVC,
- separer clairement responsabilites metier, presentation et infrastructure,
- permettre a plusieurs membres de l'equipe de travailler en parallele.

## 2. Arborescence recommandee

```text
internhub/
├── app/
│   ├── Controllers/
│   ├── Core/
│   ├── Models/
│   └── Views/
├── config/
├── docs/
├── public/
├── storage/
└── tests/
```

## 3. Exemple de structure cible

```text
app/
├── Controllers/
│   ├── AuthController.php
│   ├── CompanyController.php
│   ├── OfferController.php
│   ├── StudentController.php
│   ├── PilotController.php
│   ├── ApplicationController.php
│   └── WishlistController.php
├── Core/
│   ├── App.php
│   ├── Router.php
│   ├── Request.php
│   ├── Response.php
│   ├── Controller.php
│   ├── View.php
│   ├── Session.php
│   └── Auth.php
├── Models/
│   ├── User.php
│   ├── Company.php
│   ├── Offer.php
│   ├── Skill.php
│   ├── Application.php
│   └── WishlistItem.php
└── Views/
    ├── layouts/
    ├── auth/
    ├── companies/
    ├── offers/
    ├── students/
    ├── pilots/
    ├── applications/
    ├── wishlist/
    └── errors/
```

## 4. Role des dossiers

### `app/Core`

Contient le noyau technique du projet a prevoir :

- `App.php` : bootstrap applicatif et execution de la requete,
- `Router.php` : enregistrement et resolution des routes,
- `Request.php` : lecture de la requete HTTP,
- `Response.php` : generation des reponses HTTP,
- `Controller.php` : classe mere des controleurs,
- `View.php` : rendu des vues avec layout.

### `app/Controllers`

Contient les controleurs applicatifs. Chaque controleur orchestre une action, prepare les donnees et choisit la vue ou la reponse adaptee.

### `app/Models`

Reserve pour les entites metier, repositories, services d'acces aux donnees et logique metier reutilisable.

Les acces a la base doivent s'appuyer sur `PHP PDO` avec requetes preparees, centralises dans une couche de connexion commune plutot que du SQL disperse dans les controleurs.

### `app/Views`

Contient les vues HTML rendues cote serveur :

- `layouts/` pour les gabarits communs,
- un sous-dossier par domaine fonctionnel.

### `config`

Contient la configuration applicative et le registre des routes.

### `public`

Point d'entree HTTP de l'application a prevoir :

- `index.php`,
- `.htaccess`,
- assets publics si necessaire.

### `storage`

Reserve pour les fichiers temporaires, caches, logs et, plus tard, les uploads.

### `tests`

Contient les tests unitaires a prevoir pour PHPUnit.

## 5. Conventions de depart

- Un controleur par domaine fonctionnel.
- Une route = une action = une responsabilite claire.
- Les vues ne contiennent pas de logique metier.
- Les validations ne doivent pas vivre dans les vues.
- Les acces base de donnees ne doivent pas etre codes directement dans les controleurs.
- Les acces SQL doivent passer par `PHP PDO` et des requetes preparees.

## 6. Repartition de travail possible

Les prochains lots de travail peuvent etre distribues ainsi :

- membre 1 : routage et base des controleurs metier,
- membre 2 : layout global, composants de vues et pages publiques,
- membre 3 : modelisation des donnees et schema SQL,
- membre 4 : authentification, sessions et permissions.

## 7. Routes a prevoir en premier

- `/` : page d'accueil,
- `/login` : authentification,
- `/companies` : liste des entreprises,
- `/offers` : liste des offres,
- `/applications` : suivi des candidatures,
- `/wishlist` : liste d'interets etudiant.

## 8. Evolution prevue

La structure est volontairement minimale. Elle pourra evoluer avec :

- un systeme de middlewares,
- une couche `Repositories`,
- une couche `Services`,
- une gestion centralisee des erreurs,
- un chargeur de configuration par environnement,
- des tests plus cibles par domaine.

## 9. Documents complementaires a produire avant le code

- un schema de routage,
- un premier MCD,
- un dictionnaire de donnees,
- une convention de nommage pour les controleurs, vues et routes,
- une liste des vues a produire par role.
