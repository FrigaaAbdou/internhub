# Specification detaillee - Pages de management CRUD

Ce document sert de handoff direct pour le web designer sur les pages de management CRUD.

Il couvre les ecrans de gestion des offres et des entreprises partages par les roles `Pilote` et `Administrateur`.

Pages couvertes :

- gestion des offres,
- creation d'offre,
- edition d'offre,
- gestion des entreprises,
- creation d'entreprise,
- edition d'entreprise.

Important :

- ces pages ont une logique de back-office operationnel,
- elles ne doivent pas reprendre le ton marketing des pages publiques,
- elles ne doivent pas non plus etre confondues avec les dashboards de role,
- les pages detail publiques d'offre et d'entreprise ont deja leur propre specification et ne sont pas redescrites ici, meme si elles peuvent exposer un CTA `Modifier` pour les roles autorises.

## 1. Sources de reference

Ce document s'appuie sur :

- [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md)
- [16-navigation-et-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/16-navigation-et-parcours.md)
- [18-wireframes-structurels-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/18-wireframes-structurels-mvp.md)
- [19-systeme-composants-ui.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/19-systeme-composants-ui.md)
- [20-matrice-etats-formulaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/20-matrice-etats-formulaires.md)
- [21-spec-responsive-mobile-first.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/21-spec-responsive-mobile-first.md)
- [22-accessibilite-integree.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/22-accessibilite-integree.md)
- [04-roles-et-permissions.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/04-roles-et-permissions.md)

## 2. Regles de cadrage

Cette famille de pages doit etre pensee comme un espace de gestion.

Le design doit favoriser :

- la lisibilite des listes,
- la rapidite d'action,
- la comprehension du statut,
- la prevention des erreurs.

### 2.1 Ce que ces pages doivent inspirer

- ordre,
- fiabilite,
- efficacite,
- controle.

### 2.2 Ce qu'elles ne doivent pas devenir

- un ERP complique,
- un dashboard analytique,
- un espace marketing,
- un formulaire inutilement sophistiqué.

### 2.3 Variations de role

Les pages sont les memes en structure pour `Pilote` et `Administrateur`.

Ce qui varie :

- le label de role visible,
- le contexte de navigation,
- l'etendue du perimetre de donnees,
- eventuellement certains CTA de retour.

Ce qui ne doit pas varier :

- la structure de base,
- les formulaires,
- la lisibilite des etats,
- la prevention des actions destructives.

## 3. Shell commun des pages CRUD

### 3.1 Pages liste / gestion

Blocs obligatoires :

- contexte role,
- titre de module,
- CTA creation,
- barre de recherche,
- resume de resultats,
- tableau ou liste,
- pagination,
- etat vide si necessaire.

### 3.2 Pages formulaire

Blocs obligatoires :

- contexte role,
- titre `Creer` ou `Modifier`,
- formulaire principal,
- erreurs inline,
- CTA principal,
- CTA annuler.

### 3.3 Logique visuelle commune

Pour les pages liste :

- le CTA `Creer` doit etre visible immediatement,
- le tableau doit etre lisible avant d'etre decoratif,
- les actions doivent etre compactes mais claires.

Pour les pages formulaire :

- les champs doivent etre aeres,
- les groupes logiques doivent etre evidents,
- le bouton principal doit etre unique.

## 4. Page - Gestion des offres

Routes :

- `/{scope}/offres`
- exemple :
  - `/dashboard/pilote/offres`
  - `/admin/offres`

### 4.1 But produit

Permettre a l'utilisateur autorise de gerer le catalogue d'offres de son perimetre.

Cette page doit faciliter :

- la recherche d'une offre,
- la lecture rapide de son statut,
- l'acces a l'edition,
- la prevention des suppressions invalides.

### 4.2 Contenu obligatoire

- titre `Gestion des offres`,
- CTA `Creer une offre`,
- recherche texte,
- resume de resultats,
- tableau avec colonnes :
  - offre,
  - entreprise,
  - contrat,
  - statut,
  - candidatures,
  - actions,
- pagination,
- etat vide.

### 4.3 Hierarchie visuelle

Ordre recommande :

1. titre + CTA creation,
2. recherche,
3. resultats,
4. tableau,
5. pagination.

Le statut de publication et le nombre de candidatures doivent ressortir rapidement.

### 4.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Titre module + CTA creer une offre                                                |
+----------------------------------------------------------------------------------+
| Recherche                                                                         |
| [search.........................................................] [Rechercher]   |
+----------------------------------------------------------------------------------+
| Resume resultats                                                                  |
+----------------------------------------------------------------------------------+
| Tableau offres                                                                    |
| Offre | Entreprise | Contrat | Statut | Candidatures | Actions                   |
| ligne 1                                                                            |
| ligne 2                                                                            |
| ligne 3                                                                            |
+----------------------------------------------------------------------------------+
| Pagination                                                                        |
+----------------------------------------------------------------------------------+
```

### 4.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre + CTA creation             |
+----------------------------------+
| Recherche                        |
| [search.......................]  |
| [Rechercher]                    |
+----------------------------------+
| Resume resultats                 |
+----------------------------------+
| Carte offre 1                    |
| titre / entreprise / ville       |
| contrat / statut / candidatures  |
| actions                          |
+----------------------------------+
| Carte offre 2                    |
+----------------------------------+
| Pagination                       |
+----------------------------------+
```

### 4.6 Actions par ligne

Actions obligatoires :

- `Voir` si l'offre est publiee,
- `Modifier`,
- `Supprimer`.

Comportement UX important :

- si la suppression est interdite car des candidatures existent, l'etat doit etre explicite,
- l'action supprimee ou desactivee doit rester comprehensible,
- le statut `publiee` vs `brouillon` doit etre visible immediatement.

### 4.7 Etats a designer

- liste nominale,
- recherche active,
- page avec beaucoup de resultats,
- aucune offre,
- offre publiee,
- offre brouillon,
- suppression interdite car candidatures existantes.

### 4.8 A ne pas inventer

- pas de tri avance si non implemente,
- pas de bulk delete,
- pas de workflow editorial multi-etapes.

## 5. Page - Creation / edition d'offre

Routes :

- `/{scope}/offres/create`
- `/{scope}/offres/{id}/edit`

### 5.1 But produit

Permettre de creer ou modifier une offre clairement et sans ambiguite.

### 5.2 Contenu obligatoire

- titre de page dynamique : `Creer une offre` ou `Modifier une offre`,
- champ entreprise,
- champ titre,
- champ localisation,
- champ type de contrat,
- champ description,
- case a cocher `Publier immediatement cette offre`,
- erreurs inline,
- CTA `Enregistrer`,
- CTA `Annuler`.

### 5.3 Hierarchie visuelle

Ordre recommande :

1. contexte de page,
2. rattachement entreprise,
3. informations descriptives,
4. statut de publication,
5. actions.

### 5.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Carte formulaire large                                                            |
| Titre page                                                                        |
| Entreprise                                                                        |
| Titre                                                                             |
| Localisation                                                                      |
| Type de contrat                                                                   |
| Description                                                                       |
| Publication immediate                                                             |
| [Enregistrer] [Annuler]                                                           |
+----------------------------------------------------------------------------------+
```

### 5.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre page                       |
+----------------------------------+
| Entreprise                       |
+----------------------------------+
| Titre                            |
+----------------------------------+
| Localisation                     |
+----------------------------------+
| Type de contrat                  |
+----------------------------------+
| Description                      |
+----------------------------------+
| Publication immediate            |
+----------------------------------+
| CTA enregistrer                  |
| CTA annuler                      |
+----------------------------------+
```

### 5.6 Etats a designer

- creation vide,
- edition pre-remplie,
- erreurs de validation,
- entreprise non choisie,
- brouillon,
- publication immediate active.

### 5.7 A ne pas inventer

- pas de blocs competences complexes si non exposes dans le produit actuel,
- pas de publication programmee,
- pas d'onglets superflus.

## 6. Page - Gestion des entreprises

Routes :

- `/{scope}/entreprises`
- exemple :
  - `/dashboard/pilote/entreprises`
  - `/admin/entreprises`

### 6.1 But produit

Permettre de gerer le catalogue des entreprises referencees.

### 6.2 Contenu obligatoire

- titre `Gestion des entreprises`,
- CTA `Creer une entreprise`,
- recherche texte,
- resume de resultats,
- tableau avec colonnes :
  - entreprise,
  - secteur,
  - ville,
  - offres,
  - actions,
- pagination,
- etat vide.

### 6.3 Hierarchie visuelle

Ordre recommande :

1. titre + CTA creation,
2. recherche,
3. resultats,
4. tableau.

Le nombre d'offres rattachees doit etre visible rapidement car il conditionne la suppression.

### 6.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Titre module + CTA creer une entreprise                                           |
+----------------------------------------------------------------------------------+
| Recherche                                                                         |
| [search.........................................................] [Rechercher]   |
+----------------------------------------------------------------------------------+
| Resume resultats                                                                  |
+----------------------------------------------------------------------------------+
| Tableau entreprises                                                               |
| Entreprise | Secteur | Ville | Offres | Actions                                   |
| ligne 1                                                                            |
| ligne 2                                                                            |
| ligne 3                                                                            |
+----------------------------------------------------------------------------------+
| Pagination                                                                        |
+----------------------------------------------------------------------------------+
```

### 6.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre + CTA creation             |
+----------------------------------+
| Recherche                        |
| [search.......................]  |
| [Rechercher]                    |
+----------------------------------+
| Resume resultats                 |
+----------------------------------+
| Carte entreprise 1               |
| nom / secteur / ville            |
| nb offres                        |
| actions                          |
+----------------------------------+
| Carte entreprise 2               |
+----------------------------------+
| Pagination                       |
+----------------------------------+
```

### 6.6 Actions par ligne

Actions obligatoires :

- `Voir`,
- `Modifier`,
- `Supprimer`.

Comportement UX important :

- si l'entreprise a des offres rattachees, la suppression doit etre visiblement desactivee ou contextualisee,
- le lien site web doit rester secondaire dans la lecture.

### 6.7 Etats a designer

- liste nominale,
- recherche active,
- aucune entreprise,
- entreprise avec site web,
- entreprise sans site web,
- suppression interdite car offres rattachees.

### 6.8 A ne pas inventer

- pas de notation entreprise si non exposee ici,
- pas de filtres complexes non prevus,
- pas de vue kanban ou autre mode alternatif.

## 7. Page - Creation / edition d'entreprise

Routes :

- `/{scope}/entreprises/create`
- `/{scope}/entreprises/{id}/edit`

### 7.1 But produit

Permettre de creer ou modifier une entreprise de facon claire et fiable.

### 7.2 Contenu obligatoire

- titre de page dynamique,
- champ nom,
- champ secteur,
- champ ville,
- champ site web,
- champ description,
- erreurs inline,
- CTA `Enregistrer`,
- CTA `Annuler`.

### 7.3 Hierarchie visuelle

Ordre recommande :

1. identite entreprise,
2. localisation et site,
3. description,
4. actions.

### 7.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Carte formulaire large                                                            |
| Titre page                                                                        |
| Nom                                                                               |
| Secteur                                                                           |
| Ville                                                                             |
| Site web                                                                          |
| Description                                                                       |
| [Enregistrer] [Annuler]                                                           |
+----------------------------------------------------------------------------------+
```

### 7.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre page                       |
+----------------------------------+
| Nom                              |
+----------------------------------+
| Secteur                          |
+----------------------------------+
| Ville                            |
+----------------------------------+
| Site web                         |
+----------------------------------+
| Description                      |
+----------------------------------+
| CTA enregistrer                  |
| CTA annuler                      |
+----------------------------------+
```

### 7.6 Etats a designer

- creation vide,
- edition pre-remplie,
- erreurs validation,
- site web invalide,
- description longue.

### 7.7 A ne pas inventer

- pas de logo upload si non implante,
- pas de multi-sections corporate,
- pas d'onglets secondaires inutiles.

## 8. Regles de style pour les pages CRUD

Ces pages doivent etre :

- plus denses que les dashboards,
- tres lisibles,
- sobres,
- operationnelles,
- coherentes entre `Pilote` et `Administrateur`.

Le designer doit privilegier :

- des tableaux robustes,
- des CTA de creation visibles,
- des formulaires clairs,
- des statuts explicites,
- des etats desactives comprehensibles.

## 9. Definition of done du lot design CRUD

Le lot est considere pret si :

- chaque page existe en desktop et mobile,
- les vues liste et formulaire sont completement definies,
- les etats vides et erreurs sont presents,
- les suppressions bloquees sont prevues visuellement,
- les structures fonctionnent pour `Pilote` comme pour `Administrateur`.

## 10. Suite recommandee

Apres ce document, la suite logique est :

1. pages systeme et support,
2. consolidation globale du package design.
