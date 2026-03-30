# Documentation projet

Ce dossier est organise par domaine pour qu'une personne qui rejoint le projet puisse comprendre rapidement :

- d'ou vient le besoin,
- quelles decisions ont ete prises,
- comment l'application doit etre construite,
- quels livrables UX servent de base a l'implementation,
- quelles sources brutes font foi.

## Structure du dossier

### `01-cadrage/`

Documents de comprehension fonctionnelle et de cadrage initial.

- [README.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/README.md)
- [01-cadrage-projet.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/01-cadrage-projet.md)
- [02-planification-projet.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/02-planification-projet.md)
- [03-referentiel-fonctionnel.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/03-referentiel-fonctionnel.md)
- [04-roles-et-permissions.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/04-roles-et-permissions.md)
- [05-zones-a-clarifier.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/05-zones-a-clarifier.md)

### `02-architecture/`

Documents de conception technique et de lecture des diagrammes.

- [README.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/README.md)
- [06-architecture-mvc.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/06-architecture-mvc.md)
- [07-diagrammes-pert-gantt.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/07-diagrammes-pert-gantt.md)
- [08-analyse-uml.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/08-analyse-uml.md)

### `03-execution/`

Documents de plan d'execution, backlog, validations P1 et cadrage du MVP.

- [README.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/README.md)
- [09-plan-phases-execution.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/09-plan-phases-execution.md)
- [10-backlog-produit.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/10-backlog-produit.md)
- [11-relecture-cahier-des-charges.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/11-relecture-cahier-des-charges.md)
- [12-validation-roles-utilisateurs.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/12-validation-roles-utilisateurs.md)
- [13-validation-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/13-validation-mvp.md)

### `04-ux/`

Livrables `P4. UX et interfaces`, du plan jusqu'au handoff final vers l'implementation.

- [README.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/README.md)
- [14-plan-implementation-p4-ux-interfaces.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/14-plan-implementation-p4-ux-interfaces.md)
- [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md)
- [16-navigation-et-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/16-navigation-et-parcours.md)
- [17-wireframes-prioritaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/17-wireframes-prioritaires.md)
- [18-wireframes-structurels-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/18-wireframes-structurels-mvp.md)
- [19-systeme-composants-ui.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/19-systeme-composants-ui.md)
- [20-matrice-etats-formulaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/20-matrice-etats-formulaires.md)
- [21-spec-responsive-mobile-first.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/21-spec-responsive-mobile-first.md)
- [22-accessibilite-integree.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/22-accessibilite-integree.md)
- [23-prototype-validation-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/23-prototype-validation-parcours.md)
- [24-handoff-implementation-p4.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/24-handoff-implementation-p4.md)

### `05-sources/`

Sources brutes externes ou semi-brutes qui servent de reference au reste de la documentation.

- [README.md](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/README.md)
- `permissions/`
- `uml/`

## Source de verite

Le fichier de reference pour les droits d'acces est :

- [Matrice_permissions_2025_V2_1.json](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/permissions/Matrice_permissions_2025_V2_1.json)

Si un document interprete mal la matrice, c'est le document qui doit etre corrige.

## Ordre de lecture recommande

Pour une nouvelle personne dans l'equipe :

1. lire [01-cadrage/README.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/README.md),
2. lire [03-execution/13-validation-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/13-validation-mvp.md),
3. lire [02-architecture/06-architecture-mvc.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/06-architecture-mvc.md),
4. lire [04-ux/24-handoff-implementation-p4.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/24-handoff-implementation-p4.md),
5. consulter ensuite les details de la section concernee.

## Regles de travail

- Toute decision importante doit etre tracee dans la bonne section, pas laissee en message oral.
- Toute fonctionnalite doit pointer vers au moins un code `SFx` ou une decision documentee.
- Toute correction de permissions doit etre verifiee contre la matrice JSON.
- Toute evolution UX qui change les parcours doit mettre a jour les documents `04-ux/`.
- Toute evolution technique qui change la structure cible doit mettre a jour `02-architecture/`.

## Prochaine etape recommandee

Le dossier documentaire est maintenant structure.

La suite logique est de lancer l'implementation du MVP :

1. initialiser la structure MVC et la connexion `PHP PDO`,
2. declarer les routes MVP et les guards de role,
3. implementer les layouts, composants communs et pages systeme,
4. livrer les parcours `Visiteur`, `Etudiant` puis `Pilote`,
5. rejouer les validations de parcours avant gel de la version de soutenance.
