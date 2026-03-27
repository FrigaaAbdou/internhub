# Planification projet

## 1. Remarque importante

Le sujet annonce un projet decoupe en "4 temps", mais detaille en realite `6 phases`. Pour eviter toute ambiguite, l'equipe peut retenir en interne une planification en `6 phases`, qui correspond au niveau de detail effectivement fourni.

## 2. Phases projet retenues

### Phase 1 - Lancement et cadrage

Objectifs :

- constituer l'equipe,
- clarifier le cahier des charges,
- definir les roles Scrum,
- initialiser le backlog,
- fixer les conventions de travail et de documentation.

Livrables :

- cadrage projet valide,
- backlog initial,
- documentation des hypotheses,
- organisation d'equipe.

### Phase 2 - UX, maquettage et frontend statique

Objectifs :

- produire les wireframes des pages principales,
- definir les parcours utilisateurs,
- appliquer une approche mobile first,
- commencer l'integration HTML/CSS.

Livrables :

- maquettes des ecrans cles,
- navigation entre pages,
- premier frontend statique responsive.

### Phase 3 - Backend initial

Objectifs :

- poser l'architecture MVC,
- definir les routes,
- creer les premiers controleurs, vues et modeles,
- simuler temporairement certaines donnees si besoin.

Livrables :

- squelette applicatif MVC,
- routage fonctionnel,
- premiers parcours dynamiques.

### Phase 4 - Modelisation et base de donnees

Objectifs :

- definir le MCD,
- convertir en schema relationnel,
- creer la base de donnees,
- poser les cles etrangeres.

Livrables :

- MCD,
- dictionnaire de donnees,
- schema SQL initial.

### Phase 5 - Backend avance et securisation

Objectifs :

- connecter l'application a la base,
- implementer l'authentification,
- appliquer les restrictions d'acces,
- produire les tests unitaires requis.

Livrables :

- authentification complete,
- gestion des permissions,
- acces base de donnees,
- premier lot de tests PHPUnit.

### Phase 6 - Finalisation

Objectifs :

- ajouter les comportements JavaScript utiles,
- corriger les derniers ecarts,
- preparer la demonstration,
- finaliser la documentation et la soutenance.

Livrables :

- version de demonstration,
- dossier de justification,
- support de soutenance,
- checklist finale de validation.

## 3. Proposition de sprints

Cette proposition est une base de travail. Elle devra etre adaptee au rythme reel du bloc.

### Sprint 0 - Installation et cadrage

- structure du depot,
- conventions Git,
- documentation initiale,
- backlog brut,
- definition du MVP.

### Sprint 1 - Parcours publics

- accueil,
- liste et detail entreprises,
- liste et detail offres,
- navigation responsive.

### Sprint 2 - Comptes et roles

- authentification,
- sessions,
- controle d'acces,
- gestion des comptes administrateur, pilote, etudiant.

### Sprint 3 - Gestion metier coeur

- CRUD entreprises,
- CRUD offres,
- recherche et filtres,
- pagination.

### Sprint 4 - Candidatures et wish-list

- candidature et depot de fichiers,
- suivi des candidatures,
- wish-list etudiant,
- vue pilote sur les candidatures de ses etudiants.

### Sprint 5 - Base, tests et finalisation

- branchement complet a la base,
- statistiques,
- tests unitaires,
- SEO,
- mentions legales,
- preparation soutenance.

## 4. MVP recommande

Le MVP devrait couvrir en priorite :

- authentification,
- affichage et recherche d'offres,
- affichage et recherche d'entreprises,
- gestion minimale des comptes,
- candidature et suivi etudiant,
- restrictions d'acces selon les roles.

Peuvent etre traites apres stabilisation du coeur :

- statistiques avancees,
- optimisation SEO fine,
- PWA bonus.

## 5. Definition de termine

Une fonctionnalite est consideree terminee si :

- son comportement est conforme a la specification retenue,
- ses droits d'acces sont verifies,
- ses validations front et back existent,
- sa vue responsive est acceptable,
- sa documentation est mise a jour,
- sa demonstration est explicable en soutenance.
