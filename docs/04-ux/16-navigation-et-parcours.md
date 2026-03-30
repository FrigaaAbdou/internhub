# Navigation et parcours

Ce document lance le `Lot 2 - Architecture de navigation` de la phase `P4`.

Il traduit l'inventaire des vues en regles de navigation concretes :

- navigation principale par role,
- redirections apres login,
- comportements en cas d'acces refuse,
- retours entre liste, detail et action,
- parcours critiques a respecter avant implementation.

## 1. Sources de reference

- [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md)
- [13-validation-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/13-validation-mvp.md)
- [12-validation-roles-utilisateurs.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/12-validation-roles-utilisateurs.md)
- [04-roles-et-permissions.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/04-roles-et-permissions.md)

Regle de priorite :
les permissions de navigation et d'action doivent toujours rester compatibles avec la `Matrice_permissions_2025_V2_1.json`.

## 2. Principes de navigation

- un utilisateur ne doit jamais voir une navigation qui promet une action interdite par son role,
- les pages publiques doivent rester utiles sans connexion,
- les pages protegees doivent soit rediriger vers `login`, soit afficher `403` selon le contexte,
- les parcours MVP doivent rester courts et lisibles,
- les retours utilisateur doivent privilegier la continuite du parcours en cours,
- les dashboards ne doivent pas etre des impasses mais des hubs d'orientation.

## 3. Navigation globale publique

### Header public

Elements visibles par defaut :

- logo ou lien vers `/`
- lien `Offres`
- lien `Entreprises`
- lien `Connexion`

Elements optionnels hors MVP :

- lien `A propos`
- lien `Statistiques`
- lien `Landing`

Comportement :

- si l'utilisateur n'est pas connecte, les CTA d'action protegee doivent mener vers `/login`,
- si l'utilisateur est deja connecte, `Connexion` disparait et laisse place a la navigation de role.

### Footer public

Elements minimum :

- lien accueil
- lien offres
- lien entreprises
- mentions legales si la page existe

## 4. Navigation par role

### 4.1 Etudiant

Navigation principale MVP recommandee :

- `Offres`
- `Entreprises`
- `Mes candidatures`
- `Deconnexion`

Navigation secondaire hors MVP :

- `Mon espace`
- `Profil`
- `Wishlist`

Point d'entree recommande :

- cible ideale long terme : `/dashboard/etudiant`
- fallback MVP recommande : `/offres`

Justification :
le dashboard etudiant reste hors MVP. Rediriger vers `/offres` permet d'atterrir directement sur l'action principale la plus utile.

### 4.2 Pilote

Navigation principale MVP recommandee :

- `Dashboard pilote`
- `Etudiants`
- `Candidatures promo`
- `Creer un compte etudiant`
- `Offres`
- `Entreprises`
- `Deconnexion`

Navigation secondaire hors MVP :

- `Statistiques`
- `Gestion des offres`
- `Gestion des entreprises`

Point d'entree recommande :

- cible MVP : `/dashboard/pilote`

Justification :
le pilote a deja un vrai hub de supervision dans le MVP.

### 4.3 Administrateur

Navigation principale recommandee hors MVP :

- `Dashboard admin`
- `Comptes`
- `Entreprises`
- `Offres`
- `Statistiques`
- `Deconnexion`

Point d'entree recommande :

- cible ideale long terme : `/dashboard/admin`
- fallback si le dashboard admin n'est pas encore implemente : `/admin/comptes`

Justification :
l'administrateur doit arriver sur une vue de gestion, pas sur une page publique.

## 5. Regles de redirection

### 5.1 Redirection apres login

La redirection apres authentification doit etre determinee par le role.

Regle recommandee :

| Role | Cible primaire | Fallback MVP |
| --- | --- | --- |
| Etudiant | `/dashboard/etudiant` | `/offres` |
| Pilote | `/dashboard/pilote` | `/dashboard/pilote/etudiants` |
| Administrateur | `/dashboard/admin` | `/admin/comptes` |

Regle technique :

- si la cible primaire n'est pas encore implementee, utiliser automatiquement le fallback,
- si l'utilisateur essayait d'acceder a une page protegee avant login, le systeme peut revenir a cette page apres authentification si le role y est autorise.

### 5.2 Redirection apres logout

Regle recommandee :

- redirection vers `/`
- message flash de deconnexion si le systeme de messages existe

### 5.3 Redirection en cas d'acces refuse

Deux cas doivent etre distingues :

- utilisateur non connecte : redirection vers `/login`
- utilisateur connecte mais non autorise : affichage `403`

Exemples :

- `Anonyme` qui tente `/offres/{id}/postuler` -> `/login`
- `Pilote` qui tente `/offres/{id}/postuler` -> `403`
- `Etudiant` qui tente `/dashboard/pilote/etudiants` -> `403`

### 5.4 Redirection en cas de ressource hors perimetre

Regles :

- ressource inexistante -> `404`
- etudiant hors promo pour un pilote -> `403`
- candidature deja envoyee -> retour sur detail offre ou formulaire avec message metier

## 6. Regles de retour entre pages

### Offres

Parcours standard :

- liste offres -> detail offre -> candidature -> candidatures etudiant

Regles de retour :

- depuis detail offre : retour vers la liste d'offres avec conservation des filtres si possible
- depuis candidature : retour vers detail offre ou vers `Mes candidatures` apres succes

### Entreprises

Parcours standard :

- liste entreprises -> detail entreprise -> detail offre associee

Regles de retour :

- depuis detail entreprise : retour vers la liste entreprises
- depuis detail offre ouverte depuis une entreprise : lien retour vers l'entreprise si le contexte est connu

### Pilotage

Parcours standard :

- dashboard pilote -> liste etudiants -> candidatures d'un etudiant

Regles de retour :

- depuis candidatures d'un etudiant : retour vers sa fiche ou vers la liste etudiants
- depuis creation de compte etudiant : retour vers la liste etudiants avec message succes

## 7. Parcours critiques MVP

### 7.1 Visiteur

Parcours MVP :

1. `/`
2. `/offres`
3. `/offres/{id}`
4. tentative de postuler
5. redirection `/login`

But UX :

- permettre la decouverte,
- faire comprendre qu'une authentification est necessaire pour agir.

### 7.2 Etudiant

Parcours MVP :

1. `/login`
2. redirection rolee vers `/offres` en fallback MVP
3. `/offres`
4. `/offres/{id}`
5. `/offres/{id}/postuler`
6. succes
7. `/dashboard/etudiant/candidatures`

But UX :

- demonstrer le coeur produit sans ecran inutile entre l'authentification et l'action.

### 7.3 Pilote

Parcours MVP :

1. `/login`
2. `/dashboard/pilote`
3. `/dashboard/pilote/etudiants`
4. `/dashboard/pilote/etudiants/{id}/candidatures`

Parcours secondaire MVP :

1. `/dashboard/pilote/etudiants`
2. `/dashboard/pilote/etudiants/create`
3. succes
4. retour liste etudiants

But UX :

- mettre en avant la supervision par promotion,
- rendre visible la capacite du pilote a gerer les comptes etudiants.

### 7.4 Administrateur

Parcours minimal hors MVP strict :

1. `/login`
2. `/admin/comptes` en fallback

But UX :

- garantir une navigation coherente si l'admin est inclus dans une demo technique plus large.

## 8. Regles de garde UX

- masquer les boutons d'action interdits par role,
- ne jamais compter uniquement sur le masquage visuel ; le controle serveur reste obligatoire,
- afficher un bouton `Postuler` uniquement pour `Etudiant`,
- afficher les actions de creation de compte etudiant uniquement pour `Pilote` et `Administrateur`,
- ne jamais afficher les entrees de navigation pilote a un etudiant,
- ne jamais afficher les entrees admin a un pilote ou un etudiant,
- afficher des messages d'acces explicites quand une action echoue a cause du role.

## 9. Navigation MVP recommandee par ecran

| Ecran | Navigation attendue |
| --- | --- |
| Accueil | header public + CTA offres/entreprises/login |
| Login | retour accueil + message d'erreur + aide minimale |
| Liste offres | header role ou public + filtres + pagination |
| Detail offre | retour liste + action contextuelle selon role |
| Candidature | retour detail offre + annulation + soumission |
| Candidatures etudiant | navigation etudiant + retour offres |
| Dashboard pilote | navigation pilote + raccourcis supervision |
| Liste etudiants pilote | navigation pilote + creation compte |
| Candidatures cote pilote | navigation pilote + retour etudiants |
| Erreurs 403/404/500 | retour accueil + retour contexte si disponible |

## 10. Decisions ouvertes

- garder ou supprimer `/landing`
- garder ou supprimer `/about`
- supprimer officiellement `/register` ou le reattribuer
- figer la convention finale de nommage des routes
- confirmer la presence ou non d'un dashboard etudiant dans la premiere livraison
- confirmer si les statistiques publiques auront une page dediee ou un simple bloc public

## 11. Critere de sortie du Lot 2

Le `Lot 2` sera considere comme exploitable si :

- chaque role a une navigation principale claire,
- les redirections apres login sont definies,
- les comportements `login / 403 / 404` sont distingues,
- les retours entre liste, detail et action sont documentes,
- les parcours MVP sont complets et sans impasse,
- la navigation ne contredit ni le MVP ni la matrice.
