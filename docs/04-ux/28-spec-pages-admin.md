# Specification detaillee - Pages administrateur

Ce document sert de handoff direct pour le web designer sur l'espace administrateur.

Il couvre les pages d'administration generale et de gestion des comptes.

Pages couvertes :

- dashboard administrateur,
- liste des comptes,
- creation de compte,
- edition de compte.

Important :
la gestion des entreprises et des offres cote administrateur n'est pas detaillee ici.
Elle devra etre couverte dans un document distinct pour les pages de management CRUD, car leur logique UX est differente de la logique de gouvernance et de gestion des acces.

## 1. Sources de reference

Ce document s'appuie sur :

- [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md)
- [16-navigation-et-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/16-navigation-et-parcours.md)
- [18-wireframes-structurels-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/18-wireframes-structurels-mvp.md)
- [19-systeme-composants-ui.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/19-systeme-composants-ui.md)
- [20-matrice-etats-formulaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/20-matrice-etats-formulaires.md)
- [21-spec-responsive-mobile-first.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/21-spec-responsive-mobile-first.md)
- [22-accessibilite-integree.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/22-accessibilite-integree.md)
- [12-validation-roles-utilisateurs.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/12-validation-roles-utilisateurs.md)

## 2. Regles de cadrage

L'espace administrateur n'est pas un espace de consultation simple.
Il doit exprimer la gouvernance du systeme et la gestion fiable des acces.

### 2.1 Ce que l'administrateur peut faire

- acceder au dashboard global,
- consulter les volumes clés de la plateforme,
- gerer les comptes pilote et etudiant,
- creer un compte,
- modifier un compte,
- supprimer un compte,
- acceder ensuite a la gestion des entreprises et des offres.

### 2.2 Ce que l'administrateur ne doit pas sembler faire si ce n'est pas implemente

- supervision detaillee des candidatures comme le pilote,
- analyse avancee type BI,
- edition complexe des permissions a la main,
- gestion d'audit systeme si non disponible.

### 2.3 Ton UX attendu

L'espace admin doit donner une impression de :

- maitrise,
- rigueur,
- clarté,
- confiance.

Le design doit etre plus institutionnel que l'espace etudiant.
Il doit etre plus sobre, plus structure, et plus systemique.

## 3. Shell commun de la zone admin

### 3.1 Elements obligatoires

- contexte role `Administrateur`,
- titre de page tres clair,
- actions globales visibles,
- messages systeme,
- contenu principal structure,
- retours simples vers les modules de gestion.

### 3.2 Logique d'ensemble

L'administrateur doit pouvoir passer facilement :

- du dashboard,
- vers les comptes,
- puis vers la creation ou l'edition d'un compte,
- sans perdre la lisibilite de l'etat global.

Le design doit donc separer nettement :

- la supervision generale,
- la liste de donnees,
- les formulaires d'administration.

## 4. Page `V-ADM-001` - Dashboard administrateur

Route :
`/dashboard/admin`

### 4.1 But produit

Donner a l'administrateur un point d'entree global sur la plateforme et sur les modules a gerer.

Cette page doit repondre a trois questions :

- quels sont les volumes principaux,
- quels modules dois-je gerer,
- ou aller ensuite.

### 4.2 Contenu obligatoire

- titre `Dashboard admin`,
- phrase de contexte,
- cartes statistiques,
- bloc `Actions rapides`.

### 4.3 Cartes statistiques attendues

- nombre de pilotes,
- nombre d'etudiants,
- nombre d'entreprises,
- nombre d'offres publiees.

### 4.4 Actions rapides attendues

- gerer les comptes,
- gerer les entreprises,
- gerer les offres,
- consulter les statistiques.

### 4.5 Hierarchie visuelle

Ordre recommande :

1. contexte admin,
2. chiffres globaux,
3. actions modules.

Le dashboard doit etre net et direct.
Il ne doit pas etre surcharge d'illustrations ou de marketing.

### 4.6 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Eyebrow administrateur + titre + texte de contexte                                |
+----------------------------------------------------------------------------------+
| Cartes statistiques                                                                |
| [Pilotes] [Etudiants] [Entreprises] [Offres publiees]                             |
+----------------------------------------------------------------------------------+
| Actions rapides                                                                    |
| [Gerer les comptes] [Gerer les entreprises] [Gerer les offres] [Statistiques]    |
+----------------------------------------------------------------------------------+
```

### 4.7 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Eyebrow + titre + texte          |
+----------------------------------+
| Carte stat 1                     |
+----------------------------------+
| Carte stat 2                     |
+----------------------------------+
| Carte stat 3                     |
+----------------------------------+
| Carte stat 4                     |
+----------------------------------+
| Actions rapides empilees         |
+----------------------------------+
```

### 4.8 Etats a designer

- plateforme nominale,
- stats faibles ou quasi nulles,
- dashboard dense,
- dashboard minimal.

### 4.9 A ne pas inventer

- pas de graphes complexes s'ils ne sont pas alimentes,
- pas de centre d'alertes techniques si non implemente,
- pas de controle de permissions fines non prevu.

## 5. Page `V-ADM-002` - Liste des comptes

Route :
`/admin/comptes`

### 5.1 But produit

Permettre a l'administrateur de visualiser et gerer les comptes de la plateforme.

### 5.2 Contenu obligatoire

- titre `Comptes`,
- CTA `Creer un compte`,
- tableau ou liste des comptes,
- colonnes :
  - nom,
  - email,
  - role,
  - promotion,
  - actions,
- action `Modifier`,
- action `Supprimer`,
- etat vide.

### 5.3 Hierarchie visuelle

Ordre recommande :

1. titre + CTA creation,
2. tableau des comptes,
3. actions par ligne.

Le role doit etre tres lisible.
La suppression doit rester visible mais moins dominante que l'edition.

### 5.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Titre + CTA creer un compte                                                       |
+----------------------------------------------------------------------------------+
| Tableau comptes                                                                   |
| Nom | Email | Role | Promotion | Actions                                          |
| ligne 1                                                                            |
| ligne 2                                                                            |
| ligne 3                                                                            |
+----------------------------------------------------------------------------------+
```

### 5.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre + CTA creation             |
+----------------------------------+
| Carte compte 1                   |
| nom / email                      |
| role / promotion                 |
| actions                          |
+----------------------------------+
| Carte compte 2                   |
+----------------------------------+
```

### 5.6 Etats a designer

- liste nominale,
- aucun compte,
- roles differencies clairement,
- suppression en cours / confirmation.

### 5.7 A ne pas inventer

- pas de tri complexe si non prevu,
- pas de bulk actions si non implementees,
- pas de pagination fictive si la page ne la supporte pas encore.

## 6. Page `V-ADM-003` - Creation de compte

Route :
`/admin/comptes/create`

### 6.1 But produit

Permettre a l'administrateur de creer un compte pilote ou etudiant de facon fiable.

### 6.2 Contenu obligatoire

- titre de creation,
- formulaire :
  - prenom,
  - nom,
  - email,
  - role,
  - promotion,
  - mot de passe initial,
- erreurs inline,
- CTA `Creer le compte`,
- CTA `Annuler`.

### 6.3 Hierarchie visuelle

Ordre recommande :

1. titre et contexte,
2. identite,
3. role et promotion,
4. mot de passe initial,
5. actions.

Le bloc role + promotion doit etre clair, car c'est la partie de gouvernance.

### 6.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Carte formulaire large                                                            |
| Titre                                                                             |
| Prenom                                                                            |
| Nom                                                                               |
| Email                                                                             |
| Role                                                                              |
| Promotion                                                                         |
| Mot de passe initial                                                              |
| [Creer le compte] [Annuler]                                                       |
+----------------------------------------------------------------------------------+
```

### 6.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre                            |
+----------------------------------+
| Prenom                           |
+----------------------------------+
| Nom                              |
+----------------------------------+
| Email                            |
+----------------------------------+
| Role                             |
+----------------------------------+
| Promotion                        |
+----------------------------------+
| Mot de passe initial             |
+----------------------------------+
| CTA creer                        |
| CTA annuler                      |
+----------------------------------+
```

### 6.6 Etats a designer

- formulaire vide,
- erreurs de validation,
- email deja utilise,
- role non selectionne,
- promotion manquante,
- succes apres creation.

### 6.7 A ne pas inventer

- pas d'assignation multi-role,
- pas de gestion de permissions a cocher,
- pas d'envoi invitation email si non implemente.

## 7. Page `V-ADM-004` - Edition de compte

Route :
`/admin/comptes/{id}/edit`

### 7.1 But produit

Permettre a l'administrateur de corriger ou mettre a jour un compte existant.

### 7.2 Contenu obligatoire

- titre d'edition,
- formulaire :
  - prenom,
  - nom,
  - email,
  - role,
  - promotion,
  - nouveau mot de passe optionnel,
- erreurs inline,
- CTA `Enregistrer`,
- CTA `Annuler`.

### 7.3 Hierarchie visuelle

Ordre recommande :

1. titre + contexte,
2. donnees identitaires,
3. role et promotion,
4. mot de passe optionnel,
5. actions.

### 7.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Carte formulaire large                                                            |
| Titre                                                                             |
| Prenom                                                                            |
| Nom                                                                               |
| Email                                                                             |
| Role                                                                              |
| Promotion                                                                         |
| Nouveau mot de passe optionnel                                                    |
| [Enregistrer] [Annuler]                                                           |
+----------------------------------------------------------------------------------+
```

### 7.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre                            |
+----------------------------------+
| Prenom                           |
+----------------------------------+
| Nom                              |
+----------------------------------+
| Email                            |
+----------------------------------+
| Role                             |
+----------------------------------+
| Promotion                        |
+----------------------------------+
| Nouveau mot de passe             |
+----------------------------------+
| CTA enregistrer                  |
| CTA annuler                      |
+----------------------------------+
```

### 7.6 Etats a designer

- formulaire nominal,
- erreurs de validation,
- changement sans mot de passe,
- changement avec mot de passe,
- succes apres sauvegarde.

### 7.7 A ne pas inventer

- pas de bloc de permission detaillee,
- pas de log d'activite si non implemente,
- pas de liaison visuelle avec les CRUD metier si ce n'est pas le but de la page.

## 8. Regles de style pour l'espace admin

L'espace admin doit etre :

- plus sobre que l'espace public,
- plus structure que l'espace pilote,
- plus orienté gouvernance que suivi.

Le designer doit privilegier :

- tableaux lisibles,
- formulaires administratifs clairs,
- badges de role bien identifies,
- actions bien hierarchisees,
- sobriete visuelle.

## 9. Definition of done du lot design admin

Le lot est considere pret si :

- chaque page existe en desktop et mobile,
- les statuts et roles sont lisibles au premier regard,
- la creation et l'edition de compte sont specifíees completement,
- les etats vides et erreurs existent,
- l'espace admin est clairement distinct du pilote et de l'etudiant.

## 10. Suite recommandee

Apres ce document, la suite logique est :

1. pages de management CRUD,
2. pages systeme et support.
