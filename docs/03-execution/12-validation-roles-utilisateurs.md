# Validation des roles utilisateurs

Ce document formalise la deuxieme etape du plan d'execution : `P1.2 - Valider les roles utilisateurs : visiteur, etudiant, pilote, administrateur`.

Il sert a figer une lecture commune des acteurs du systeme avant la validation du MVP, des routes et des regles de permissions.

## 1. Roles retenus

Les 4 roles officiellement retenus pour `InternHub` sont :

- `Anonyme` ou `Visiteur`
- `Etudiant`
- `Pilote`
- `Administrateur`

Decision de travail :
le mot `Visiteur` des documents de planification et le mot `Anonyme` de la matrice de permissions designent le meme role fonctionnel.

## 2. Definition fonctionnelle de chaque role

### 2.1 Visiteur / Anonyme

Le visiteur est un utilisateur non authentifie.

Il peut :

- consulter la page d'accueil,
- consulter les entreprises,
- consulter les offres,
- acceder a la page de connexion,
- consulter les statistiques publiques.

Il ne peut pas :

- postuler,
- acceder aux dashboards,
- consulter des donnees personnelles,
- gerer des comptes,
- utiliser la wish-list.

### 2.2 Etudiant

L'etudiant est le role coeur du produit.

Il peut :

- se connecter et se deconnecter,
- rechercher et consulter des offres,
- rechercher et consulter des entreprises,
- postuler a une offre,
- consulter ses candidatures,
- gerer sa wish-list,
- acceder a son espace personnel.

Il ne peut pas :

- creer, modifier ou supprimer des offres,
- creer, modifier ou supprimer des entreprises,
- gerer les comptes,
- consulter les donnees des autres etudiants,
- acceder au suivi pilote ou a l'administration.

### 2.3 Pilote

Le pilote est un role d'encadrement pedagogique.

Il peut :

- se connecter et se deconnecter,
- consulter les entreprises et les offres,
- gerer les entreprises,
- gerer les offres,
- consulter les comptes etudiants,
- creer des comptes etudiants,
- modifier des comptes etudiants,
- supprimer des comptes etudiants,
- suivre les candidatures des etudiants de sa promotion,
- acceder a un dashboard pilote,
- consulter les statistiques.

Il ne peut pas :

- postuler,
- utiliser une wish-list etudiante,
- gerer les comptes pilotes,
- voir les donnees d'etudiants hors promotion.

### 2.4 Administrateur

L'administrateur est le role de gestion transverse de la plateforme.

Il peut :

- gerer les comptes pilotes,
- gerer les comptes etudiants,
- gerer les entreprises,
- gerer les offres,
- acceder aux vues d'administration,
- consulter les statistiques.

Il ne peut pas, selon la matrice actuelle :

- postuler a une offre,
- consulter les candidatures personnelles d'un etudiant comme un etudiant le ferait,
- utiliser la wish-list etudiante.

## 3. Modele de responsabilite retenu

Regle de priorite :
les droits d'acces ci-dessous sont derives de la `Matrice_permissions_2025_V2_1.json`, qui fait foi pour tout arbitrage sur les permissions.

Pour limiter les ambiguities fonctionnelles, la lecture suivante est recommandee :

- `Visiteur` : consultation publique,
- `Etudiant` : action metier individuelle autour de la recherche de stage,
- `Pilote` : suivi pedagogique de cohortes et controle perimetrique par promotion,
- `Administrateur` : administration globale des donnees et des acces.

## 4. Regles transversales a retenir

Les regles suivantes doivent etre considerees comme communes a l'ensemble du projet :

- toute action d'ecriture exige un utilisateur authentifie autorise,
- les donnees etudiantes doivent etre filtrees par promotion pour le role `Pilote`,
- les formulaires sensibles exigent une protection `CSRF`,
- les permissions fonctionnelles doivent etre verifiees cote serveur,
- les comptes etudiants sont crees par `Administrateur` ou `Pilote`, pas par auto-inscription publique,
- l'acces base de donnees passe par `PHP PDO` et des requetes preparees.

## 5. Arbitrages encore necessaires

La validation des roles est suffisamment avancee pour continuer, mais ces points doivent encore etre confirms sans contredire la matrice :

- un etudiant dispose-t-il d'une page `Mon profil` distincte de `SFx16` ?
- la route `/register` doit-elle disparaitre des parcours publics ?
- les coordonnees entreprise detaillees sont-elles publiques ou reservees aux comptes connectes ?

## 6. Decision projet proposee pour cloturer P1.2

Sauf arbitrage contraire en reunion, la validation d'equipe peut retenir :

1. `Visiteur` et `Anonyme` sont un seul et meme role.
2. Les comptes etudiants ne sont pas crees par auto-inscription.
3. Le role `Pilote` est borne par la notion de promotion.
4. Le role `Administrateur` gere la plateforme mais n'emprunte pas les parcours personnels etudiants.
5. La `Matrice_permissions_2025_V2_1.json` sert de reference unique pour les droits d'acces, le MVP, les routes protegees et les tests d'autorisation.

## 7. Sortie attendue

L'etape `P1.2` peut etre consideree comme exploitable si l'equipe valide :

- les 4 roles officiels,
- leur perimetre de responsabilite,
- leurs grandes interdictions,
- la correspondance `Visiteur = Anonyme`,
- la politique de creation des comptes etudiants.

## 8. Statut propose

- `P1.2` : documente
- `Validation equipe` : a faire
- `Pret pour suite` : oui, sous reserve des arbitrages du chapitre 5 qui ne contredisent pas la matrice
