# Audit P8.1 - validations et securite

Ce document formalise l audit initial de `P8.1`.

Il couvre :

- les routes mutantes,
- les formulaires applicatifs,
- les validations serveur,
- la presence de `CSRF`,
- le socle session / cookie,
- les principaux ecarts a corriger avant de considerer l application comme stabilisee.

## 1. Perimetre audite

Modules verifies :

- authentification,
- comptes admin,
- comptes etudiants cote pilote,
- entreprises,
- offres,
- candidature,
- wish-list,
- profil etudiant,
- session et middleware `CSRF`.

Fichiers principaux relus :

- [routes.php](/Users/abdoufrigaa/Projects/internhub/config/routes.php)
- [Session.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Session.php)
- [CsrfMiddleware.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Middleware/CsrfMiddleware.php)
- [AuthController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/AuthController.php)
- [AdminController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/AdminController.php)
- [PilotController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/PilotController.php)
- [CompanyController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/CompanyController.php)
- [OfferController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/OfferController.php)
- [ApplicationController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/ApplicationController.php)
- [StudentController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/StudentController.php)
- [WishlistController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/WishlistController.php)
- [init-sqlite.php](/Users/abdoufrigaa/Projects/internhub/database/init-sqlite.php)

## 2. Etat general

Constat global :

- toutes les routes `POST` declarees passent par `CsrfMiddleware`,
- tous les formulaires `POST` relus injectent `csrf_field()`,
- la plupart des formulaires critiques ont une validation serveur effective,
- les roles sont controles cote route et completes par des gardes metier dans les modules sensibles,
- la session serveur utilise deja `HttpOnly` et `SameSite`.

Conclusion rapide :

- le socle est deja serieux pour un projet de soutenance,
- `P8.1` ne part pas de zero,
- les corrections restantes sont surtout des durcissements de reference et de validation de donnees reliees.

## 3. Matrice des formulaires et routes mutantes

| Zone | Route | Validation serveur | `CSRF` | Etat |
| --- | --- | --- | --- | --- |
| Login | `POST /login` | email + mot de passe requis | Oui | Solide |
| Logout | `POST /logout` | pas de saisie libre | Oui | Solide |
| Wish-list ajout | `POST /offres/{id}/wishlist` | existence offre + blocage doublon | Oui | Solide |
| Wish-list retrait | `POST /dashboard/etudiant/wishlist/{offerId}/delete` | presence dans la wish-list | Oui | Solide |
| Candidature | `POST /offres/{id}/postuler` | doublon + lettre + CV + taille | Oui | A durcir sur le type reel du fichier |
| Profil etudiant | `POST /dashboard/etudiant/profil` | nom, prenom, email, mot de passe optionnel | Oui | Solide |
| Creation etudiant pilote | `POST /dashboard/pilote/etudiants/create` | nom, prenom, email unique, mot de passe | Oui | A durcir sur la promotion |
| Edition etudiant pilote | `POST /dashboard/pilote/etudiants/{id}/edit` | nom, prenom, email unique, mot de passe optionnel | Oui | Solide |
| Suppression etudiant pilote | `POST /dashboard/pilote/etudiants/{id}/delete` | garde promo | Oui | Solide |
| Creation compte admin | `POST /admin/comptes/create` | nom, prenom, email, role, promotion, mot de passe | Oui | A durcir sur la promotion |
| Edition compte admin | `POST /admin/comptes/{id}/edit` | nom, prenom, email, role, promotion, mot de passe optionnel | Oui | A durcir sur la promotion |
| Suppression compte admin | `POST /admin/comptes/{id}/delete` | compte cible verifie | Oui | Solide |
| Creation entreprise | `POST /admin/entreprises/create` / `POST /dashboard/pilote/entreprises/create` | nom, secteur, ville, description, URL optionnelle | Oui | Solide |
| Edition entreprise | `POST /admin/entreprises/{id}/edit` / `POST /dashboard/pilote/entreprises/{id}/edit` | idem | Oui | Solide |
| Suppression entreprise | `POST /admin/entreprises/{id}/delete` / `POST /dashboard/pilote/entreprises/{id}/delete` | blocage si offres rattachees | Oui | Solide |
| Creation offre | `POST /admin/offres/create` / `POST /dashboard/pilote/offres/create` | entreprise, titre, ville, contrat, description | Oui | A durcir sur l entreprise cible |
| Edition offre | `POST /admin/offres/{id}/edit` / `POST /dashboard/pilote/offres/{id}/edit` | idem | Oui | A durcir sur l entreprise cible |
| Suppression offre | `POST /admin/offres/{id}/delete` / `POST /dashboard/pilote/offres/{id}/delete` | blocage si candidatures rattachees | Oui | Solide |

## 4. Points deja conformes

### 4.1 Protections `CSRF`

Le socle est coherent :

- `CsrfMiddleware` couvre les verbes mutateurs dans [CsrfMiddleware.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Middleware/CsrfMiddleware.php#L10),
- toutes les routes `POST` definies dans [routes.php](/Users/abdoufrigaa/Projects/internhub/config/routes.php#L17) passent par ce middleware,
- tous les formulaires `POST` relus dans `app/Views/` injectent `csrf_field()`.

### 4.2 Session serveur

Le cookie de session est deja mieux traite que dans beaucoup de projets etudiants :

- `HttpOnly` actif,
- `SameSite` configure,
- regeneration d identifiant a la connexion et a la deconnexion.

Points verifies dans [Session.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Session.php#L24) et [Auth.php](/Users/abdoufrigaa/Projects/internhub/app/Core/Auth.php#L17).

### 4.3 Validations metier deja presentes

Les controles importants existent deja :

- blocage de candidature en doublon,
- blocage des suppressions d offres avec candidatures,
- blocage des suppressions d entreprises avec offres,
- blocage hors promotion cote pilote,
- controle d unicite email sur les comptes,
- validation d URL sur l entreprise.

## 5. Ecarts constates et priorite

### Priorite 1

#### E1. Les references metier ne sont pas toutes validees contre des donnees existantes

Constat :

- `promotion_id` est seulement verifie comme entier dans [AdminController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/AdminController.php#L147),
- `company_id` est seulement verifie comme entier dans [OfferController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/OfferController.php#L197),
- l ecriture SQL accepte ensuite directement ces identifiants dans [UserRepository.php](/Users/abdoufrigaa/Projects/internhub/app/Models/UserRepository.php#L211) et [OfferRepository.php](/Users/abdoufrigaa/Projects/internhub/app/Models/OfferRepository.php#L151),
- le schema SQLite de demo ne declare pas de cles etrangeres dans [init-sqlite.php](/Users/abdoufrigaa/Projects/internhub/database/init-sqlite.php#L16).

Risque :

- creation d offres orphelines si un `company_id` invalide est poste,
- creation de comptes relies a une promotion inexistante,
- ecart entre l interface et l integrite reelle des donnees.

Correction attendue en `P8` :

- verifier l existence effective de la promotion cote serveur,
- verifier l existence effective de l entreprise cote serveur,
- ajouter ou prevoir les contraintes relationnelles minimales sur le schema de travail.

#### E2. Le controle du CV repose sur l extension du fichier, pas sur son type reel

Constat :

- le controle actuel ne verifie que l extension `pdf` et la taille dans [ApplicationController.php](/Users/abdoufrigaa/Projects/internhub/app/Controllers/ApplicationController.php#L76).

Risque :

- un fichier non PDF renomme peut passer la validation,
- le stockage accepte un fichier non conforme dans `storage/uploads/cv`.

Correction attendue en `P8` :

- verifier le `mime type` avec `finfo`,
- conserver le controle de taille,
- rejeter les fichiers dont le contenu n est pas un vrai PDF.

### Priorite 2

#### E3. Le cookie de session n est pas force en `Secure` par defaut

Constat :

- `SESSION_SECURE` vaut `false` dans [app.php](/Users/abdoufrigaa/Projects/internhub/config/app.php#L14) et [.env.example](/Users/abdoufrigaa/Projects/internhub/.env.example#L7).

Risque :

- en environnement de production mal configure, le cookie peut rester transmissible hors HTTPS.

Nuance :

- c est acceptable en local,
- ce n est pas acceptable comme valeur de reference de production.

Correction attendue en `P8` :

- documenter explicitement `SESSION_SECURE=true` en production,
- idealement rendre le comportement plus strict hors `local`.

#### E4. Les longueurs maximales et la normalisation forte restent faibles

Constat :

- les champs texte critiques sont verifies surtout sur la presence,
- il n y a pas encore de bornes explicites sur plusieurs saisies longues.

Zones concernees :

- comptes,
- offres,
- entreprises,
- profil etudiant.

Risque :

- donnees tres longues ou peu propres,
- comportements non uniformes selon la base cible.

Correction attendue en `P8` :

- definir des longueurs maximales raisonnables,
- harmoniser `trim`, casse email et validations de formats sur tous les champs critiques.

### Priorite 3

#### E5. Le schema de demo manque de contraintes d integrite visibles

Constat :

- la base SQLite de travail ne declare pas les relations attendues entre utilisateurs, promotions, offres, entreprises et candidatures dans [init-sqlite.php](/Users/abdoufrigaa/Projects/internhub/database/init-sqlite.php#L16).

Risque :

- le comportement applicatif repose surtout sur le code,
- les erreurs de donnees ne sont pas rattrapees au niveau schema.

Correction attendue en `P8` :

- renforcer le schema de demo ou,
- a minima, documenter clairement que l integrite est actuellement portee par l application.

## 6. Arbitrage de sortie pour P8.1

Lecture d audit :

- le socle validation / securite est deja globalement bon,
- il n y a pas de faille structurelle immediate sur `CSRF` ou autorisation de base,
- les corrections les plus importantes portent sur l integrite de reference et l upload de fichier.

Ordre recommande pour la suite :

1. corriger la validation d existence des references metier,
2. corriger la verification du vrai type de fichier pour le CV,
3. durcir la configuration de session pour la production,
4. uniformiser les bornes de validation et la normalisation.

## 7. Prochaine action

Passer a `P8.2 Revue complete des droits et cas limites`, ou corriger directement les ecarts `E1` et `E2` si l equipe prefere traiter les blocants avant la revue suivante.
