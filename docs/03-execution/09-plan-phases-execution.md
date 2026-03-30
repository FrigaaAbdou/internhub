# Plan de phases d'execution

Ce document propose un plan de travail complet pour developper la plateforme `InternHub` a partir des informations deja disponibles :

- cahier des charges,
- matrice des permissions,
- diagrammes UML,
- structure MVC cible,
- parcours utilisateurs,
- planification PERT/Gantt.

L'objectif est de fournir un ordre d'execution clair, defendable et exploitable par toute l'equipe.

## 1. Principes de pilotage

Le projet doit avancer selon ces regles :

- ne pas coder avant d'avoir stabilise les conventions structurantes,
- valider les zones d'ombre avant les modules sensibles,
- prioriser les parcours coeur plutot que la couverture exhaustive,
- documenter chaque decision importante,
- travailler par increments demonstrables.

## 2. Vision d'ensemble

Le plan est organise en `9 phases`.

| Phase | Intitule | Objectif principal |
| --- | --- | --- |
| P1 | Cadrage projet | stabiliser le perimetre, les roles et les regles |
| P2 | Architecture et conventions | figer l'architecture technique cible |
| P3 | Conception fonctionnelle et donnees | figer routes, donnees et droits |
| P4 | UX et interfaces | preparer les ecrans et parcours |
| P5 | Socle applicatif | mettre en place la base technique du projet |
| P6 | Modules coeur | developper offres, entreprises, comptes |
| P7 | Modules avances | developper candidatures, wish-list, suivi pilote |
| P8 | Stabilisation | securiser, tester, corriger |
| P9 | Livraison et soutenance | finaliser la demo et la justification |

## 3. Phase par phase

## P1. Cadrage projet

### Objectif

Aligner toute l'equipe sur le besoin, le perimetre et les decisions de depart.

### Etapes

1. Relire collectivement le cahier des charges.
2. Valider les roles utilisateurs : visiteur, etudiant, pilote, administrateur.
3. Valider le MVP.
4. Lister et arbitrer les zones floues identifiees.
5. Valider la methode de travail d'equipe.
6. Fixer la structure documentaire commune.

### Sorties attendues

- perimetre MVP valide,
- zones a clarifier classees,
- roles d'equipe definis,
- backlog initial brut,
- cadre de travail commun.

### Documents de reference

- `01-cadrage-projet.md`
- `03-referentiel-fonctionnel.md`
- `04-roles-et-permissions.md`
- `05-zones-a-clarifier.md`

## P2. Architecture et conventions

### Objectif

Definir une base technique unique pour eviter les divergences d'implementation.

### Etapes

1. Valider la cible `MVC + Services + Repository`.
2. Definir les conventions de nommage :
   routes, controleurs, services, repositories, vues.
3. Fixer l'organisation des dossiers.
4. Definir la strategie de routage.
5. Definir la strategie de middleware :
   auth, roles, csrf, erreurs.
6. Definir la strategie de stockage des fichiers.
7. Definir les conventions de code et de commit.

### Sorties attendues

- convention d'architecture validee,
- schema des couches applicatives,
- conventions de nommage,
- regles de securite de base,
- regles de collaboration technique.

### Documents de reference

- `06-architecture-mvc.md`
- `08-analyse-uml.md`

## P3. Conception fonctionnelle et donnees

### Objectif

Traduire le besoin metier en structure exploitable pour le developpement.

### Etapes

1. Figer les routes officielles du site.
2. Figer les parcours principaux par role.
3. Produire le MCD.
4. Deriver le schema relationnel.
5. Definir les entites metier principales.
6. Definir les contraintes :
   unicite candidature, wish-list sans doublon, appartenance promo.
7. Definir la gestion des competences comme referentiel ferme.
8. Definir la politique de suppression logique ou physique.
9. Definir la matrice finale de permissions appliquees aux routes.

### Sorties attendues

- schema de routage officiel,
- MCD valide,
- schema relationnel,
- dictionnaire de donnees,
- regles metier formelles.

### Dependances

Cette phase depend de `P1` et `P2`.

### Documents de reference

- `04-roles-et-permissions.md`
- `05-zones-a-clarifier.md`
- `08-analyse-uml.md`

## P4. UX et interfaces

### Objectif

Concevoir les ecrans a developper et stabiliser l'experience utilisateur avant implementation.

### Etapes

1. Lister toutes les pages publiques.
2. Lister toutes les pages etudiant.
3. Lister toutes les pages pilote.
4. Lister toutes les pages admin.
5. Produire les wireframes prioritaires.
6. Definir les composants communs :
   header, footer, navigation, tableaux, pagination, formulaires, messages.
7. Definir les etats de formulaire :
   vide, erreur, succes, acces refuse.
8. Definir le responsive mobile first.
9. Valider les parcours critique :
   recherche, login, postuler, wishlist, suivi candidatures.

### Sorties attendues

- wireframes des ecrans principaux,
- inventaire des vues,
- composants UI communs,
- parcours utilisateur valides.

### Dependances

Cette phase peut commencer en parallele de `P3`, mais doit etre alignee avec les routes et les permissions.

## P5. Socle applicatif

### Objectif

Mettre en place l'infrastructure minimale permettant de demarrer le developpement sans rework majeur.

### Etapes

1. Initialiser le depot et la structure de projet.
2. Mettre en place le point d'entree HTTP.
3. Mettre en place le routeur.
4. Mettre en place les classes de base :
   Request, Response, Controller, View.
5. Mettre en place les layouts et vues communes.
6. Mettre en place la gestion des erreurs :
   403, 404, 500.
7. Mettre en place la gestion de session.
8. Mettre en place la protection CSRF.
9. Mettre en place la configuration d'environnement.
10. Mettre en place la connexion de base a la base de donnees.

### Sorties attendues

- socle MVC fonctionnel,
- routes de base,
- pages d'erreur,
- session et csrf operationnels,
- base de projet commune.

### Dependances

Cette phase depend de `P2` et des decisions critiques de `P3`.

## P6. Modules coeur

### Objectif

Developper les modules indispensables au fonctionnement principal de la plateforme.

### Modules a traiter

- Authentification
- Offres
- Entreprises
- Comptes
- Dashboards

### Etapes

1. Developper le login et le logout.
2. Mettre en place la redirection selon le role.
3. Developper la liste et le detail des offres.
4. Developper la recherche et les filtres d'offres.
5. Developper la pagination.
6. Developper la liste et le detail des entreprises.
7. Developper le CRUD entreprises pour admin et pilote si confirme.
8. Developper le CRUD offres.
9. Developper la gestion des comptes admin/pilote/etudiant.
10. Developper les dashboards par role.

### Sorties attendues

- parcours public fonctionnel,
- login fonctionnel,
- gestion des offres et entreprises,
- gestion des comptes,
- dashboards de base.

### Dependances

Cette phase depend de `P5`.

## P7. Modules avances

### Objectif

Mettre en place les cas d'usage metier les plus specifique du projet.

### Modules a traiter

- Candidatures
- Wish-list
- Suivi pilote
- Statistiques
- Profil etudiant

### Etapes

1. Developper le formulaire de candidature.
2. Integrer l'upload du CV.
3. Integrer la saisie ou gestion de la lettre de motivation.
4. Bloquer les candidatures en doublon.
5. Developper la page "Mes candidatures".
6. Developper le telechargement du CV deja depose.
7. Developper l'ajout a la wish-list.
8. Developper la liste de wish-list.
9. Developper le retrait de la wish-list.
10. Developper la vue pilote sur les candidatures de sa promo.
11. Bloquer l'acces hors promo.
12. Developper les statistiques.

### Sorties attendues

- candidature complete de bout en bout,
- wishlist complete,
- suivi pilote operationnel,
- statistiques exploitables.

### Dependances

Cette phase depend de `P6` et d'une base de donnees stable.

## P8. Stabilisation

### Objectif

Amener l'application a un niveau de fiabilite presentable.

### Etapes

1. Revoir toutes les validations front et back.
2. Revoir toutes les protections CSRF.
3. Revoir les droits par role.
4. Revoir les erreurs 403, 404 et 500.
5. Verifier les cas limites :
   deja postule, offre inexistante, compte non autorise, promo invalide.
6. Ecrire les tests unitaires requis.
7. Corriger les regressions.
8. Verifier le responsive.
9. Verifier la performance des pages critiques.
10. Ajouter les mentions legales et les meta de base.

### Sorties attendues

- application stabilisee,
- lot minimal de tests,
- securite de base controlee,
- responsive valide,
- conformite technique renforcée.

### Dependances

Cette phase depend de `P6` et `P7`.

## P9. Livraison et soutenance

### Objectif

Transformer le projet en livrable defendable face au client ou au jury.

### Etapes

1. Preparer le script de demo.
2. Choisir les parcours a montrer.
3. Preparer les comptes de demonstration.
4. Preparer un jeu de donnees coherent.
5. Finaliser la documentation projet.
6. Resumer les decisions techniques.
7. Preparer les reponses aux zones d'ombre et arbitrages.
8. Repartir la parole entre les membres de l'equipe.
9. Faire une repetition complete.

### Sorties attendues

- version de demo stable,
- presentation claire,
- justification technique et fonctionnelle,
- repartition claire de la soutenance.

### Dependances

Cette phase depend de `P8`.

## 4. Ordre de priorite reel

En pratique, l'ordre a respecter est :

1. `P1` Cadrage projet
2. `P2` Architecture et conventions
3. `P3` Conception fonctionnelle et donnees
4. `P4` UX et interfaces
5. `P5` Socle applicatif
6. `P6` Modules coeur
7. `P7` Modules avances
8. `P8` Stabilisation
9. `P9` Livraison et soutenance

## 5. Regroupement en sprints recommande

| Sprint | Contenu principal |
| --- | --- |
| Sprint 0 | P1 + P2 |
| Sprint 1 | fin P3 + P4 |
| Sprint 2 | P5 + debut P6 |
| Sprint 3 | fin P6 |
| Sprint 4 | P7 |
| Sprint 5 | P8 + P9 |

## 6. Definition de fini par phase

Une phase est terminee si :

- les decisions attendues sont validees,
- les livrables existent vraiment,
- les dependances de la phase suivante sont levees,
- la documentation correspond a l'etat reel du projet.

## 7. Risques si le plan n'est pas respecte

- coder trop tot sans conventions produit des divergences d'architecture,
- traiter les permissions trop tard casse les parcours,
- repousser la base de donnees trop loin bloque les modules metier,
- repousser les tests a la fin fragilise la soutenance,
- ne pas figer les routes et les roles cree des reworks partout.

## 8. Prochaine action recommandee

La prochaine action la plus utile est de produire maintenant les trois documents suivants :

1. le schema officiel des routes,
2. le MCD initial,
3. la convention `Controller / Service / Repository`.
