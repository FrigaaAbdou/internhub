# Specification detaillee - Pages pilote

Ce document sert de handoff direct pour le web designer sur l'espace pilote.

Il couvre les pages de supervision de promotion et de gestion des comptes etudiants.

Pages couvertes :

- dashboard pilote,
- liste des etudiants,
- fiche etudiant,
- candidatures d'un etudiant,
- detail d'une candidature cote pilote,
- creation d'un compte etudiant,
- edition d'un compte etudiant.

Important :
la gestion des offres et des entreprises cote pilote n'est pas detaillee ici.
Elle devra faire l'objet d'un document separe pour les pages de management CRUD, car ces ecrans ont une logique plus proche de l'administration que du suivi de promotion.

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

Le pilote n'est pas un simple visiteur evolue.
Il a un role de supervision de promotion et de gestion encadree.

### 2.1 Ce que le pilote peut faire

- consulter le dashboard de suivi,
- voir les etudiants de sa promotion,
- consulter le detail d'un etudiant de sa promotion,
- consulter les candidatures des etudiants de sa promotion,
- telecharger les CV accessibles dans ce perimetre,
- creer un compte etudiant,
- modifier un compte etudiant,
- supprimer un compte etudiant dans son perimetre,
- acceder ensuite a la gestion des offres et des entreprises.

### 2.2 Ce que le pilote ne peut pas faire

- gerer les pilotes,
- sortir de sa promotion,
- acceder a des donnees etudiantes hors perimetre,
- modifier des droits ou permissions systeme,
- transformer l'espace de supervision en espace RH complexe.

### 2.3 Ton UX attendu

L'espace pilote doit donner une impression de :

- supervision,
- controle,
- clarté,
- responsabilite.

Ce n'est ni un CRM lourd, ni un back-office froid.
C'est un espace de pilotage academique lisible.

## 3. Shell commun de la zone pilote

### 3.1 Elements obligatoires

- contexte role `Pilote`,
- titre de page net,
- raccourcis ou actions visibles,
- messages systeme,
- contenu principal structure,
- navigation ou retours simples.

### 3.2 Logique d'ensemble

Le pilote doit pouvoir passer facilement de :

- sa vue globale,
- a la liste des etudiants,
- puis a la fiche d'un etudiant,
- puis aux candidatures de cet etudiant,
- puis au detail d'une candidature.

Le design doit rendre cette progression tres lisible.

## 4. Page `V-PIL-001` - Dashboard pilote

Route :
`/dashboard/pilote`

### 4.1 But produit

Donner au pilote une vue synthese de sa promotion et les actions immediates de supervision.

Cette page doit repondre a trois questions :

- combien d'etudiants je suis,
- quelle activite recente a eu lieu,
- quelles actions dois-je faire maintenant.

### 4.2 Contenu obligatoire

- titre `Dashboard pilote`,
- phrase de contexte,
- cartes stats,
- bloc `Actions rapides`,
- bloc `Activite recente de la promotion`.

### 4.3 Cartes statistiques attendues

- nombre d'etudiants suivis,
- nombre de candidatures de la promotion.

### 4.4 Actions rapides attendues

- voir les etudiants,
- creer un compte etudiant,
- gerer les entreprises,
- gerer les offres,
- consulter les statistiques.

### 4.5 Hierarchie visuelle

Ordre recommande :

1. contexte pilote,
2. chiffres clés,
3. actions rapides,
4. activite recente.

### 4.6 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Eyebrow pilote + titre + texte de contexte                                        |
+----------------------------------------------------------------------------------+
| Cartes statistiques                                                                |
| [Etudiants suivis] [Candidatures promo]                                            |
+----------------------------------------------------------------------------------+
| Actions rapides                                                                    |
| [Voir les etudiants] [Creer un compte] [Gerer entreprises] [Gerer offres] [Stats]|
+----------------------------------------------------------------------------------+
| Activite recente de la promotion                                                   |
| liste d'evenements / candidatures recentes                                         |
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
| Actions rapides empilees         |
+----------------------------------+
| Activite recente                 |
+----------------------------------+
```

### 4.8 Etats a designer

- promotion active avec activite,
- aucune candidature recente,
- aucun etudiant suivi,
- dashboard tres dense vs dashboard minimal.

### 4.9 A ne pas inventer

- pas de graphiques complexes non alimentes,
- pas de priorisation algorithmique fictive,
- pas de filtres analytiques lourds sur cette page.

## 5. Page `V-PIL-002` - Liste des etudiants

Route :
`/dashboard/pilote/etudiants`

### 5.1 But produit

Permettre au pilote de voir l'ensemble des etudiants rattaches a sa promotion et d'agir rapidement sur eux.

### 5.2 Contenu obligatoire

- titre `Etudiants de la promotion`,
- CTA `Creer un compte etudiant`,
- liste ou tableau des etudiants,
- actions par ligne :
  - voir,
  - candidatures,
  - modifier,
  - supprimer,
- etat vide.

### 5.3 Hierarchie visuelle

Ordre recommande :

1. titre + CTA creation,
2. liste des etudiants,
3. actions secondaires par ligne.

Le CTA creation doit etre tres visible.

### 5.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Titre + CTA creer un compte                                                       |
+----------------------------------------------------------------------------------+
| Tableau etudiants                                                                 |
| Nom | Email | Actions                                                             |
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
| Carte etudiant 1                 |
| Nom                              |
| Email                            |
| Actions                          |
+----------------------------------+
| Carte etudiant 2                 |
+----------------------------------+
```

### 5.6 Etats a designer

- liste nominale,
- aucun etudiant,
- suppression en cours ou confirmation de suppression,
- table dense avec nombreuses lignes.

### 5.7 A ne pas inventer

- pas de recherche multicritere si non prevue,
- pas de filtre par promo, puisque le pilote est deja borne a sa promotion.

## 6. Page `V-PIL-003` - Fiche etudiant

Route :
`/dashboard/pilote/etudiants/{id}`

### 6.1 But produit

Permettre au pilote de voir une synthese claire d'un etudiant et d'acceder a ses candidatures.

### 6.2 Contenu obligatoire

- nom complet,
- email,
- promotion,
- actions :
  - retour aux etudiants,
  - voir les candidatures,
  - modifier le compte,
- bloc `Resume`,
- bloc `Dernieres candidatures`.

### 6.3 Hierarchie visuelle

Ordre recommande :

1. identite etudiant,
2. actions principales,
3. bloc resume,
4. dernieres candidatures.

### 6.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Fiche etudiant                                                                    |
| nom complet                                                                       |
| email · promotion                                                                 |
| actions                                                                           |
+----------------------------------------------------------------------------------+
| Resume                                                                            |
| [Carte nombre de candidatures]                                                    |
+----------------------------------------------------------------------------------+
| Dernieres candidatures                                                            |
+----------------------------------------------------------------------------------+
```

### 6.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Nom etudiant                     |
| email / promotion                |
| actions                          |
+----------------------------------+
| Resume                           |
+----------------------------------+
| Dernieres candidatures           |
+----------------------------------+
```

### 6.6 Etats a designer

- etudiant avec candidatures,
- etudiant sans candidature,
- etudiant tres actif,
- fiche simple.

### 6.7 A ne pas inventer

- pas de commentaires internes si la feature n'existe pas,
- pas de timeline pedagogique complexe.

## 7. Page `V-PIL-004` - Candidatures d'un etudiant

Route :
`/dashboard/pilote/etudiants/{id}/candidatures`

### 7.1 But produit

Permettre au pilote d'inspecter les candidatures d'un etudiant donne.

### 7.2 Contenu obligatoire

- titre `Candidatures de [Nom etudiant]`,
- CTA retour aux etudiants,
- CTA voir la fiche etudiant,
- tableau ou liste des candidatures,
- colonnes offre / entreprise / statut / date / actions,
- action `Voir`,
- action `Telecharger le CV` si disponible.

### 7.3 Hierarchie visuelle

Ordre recommande :

1. nom de l'etudiant,
2. navigation de retour,
3. liste des candidatures,
4. actions.

### 7.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Titre page + etudiant concerné                                                    |
| CTA retour etudiants | CTA fiche etudiant                                         |
+----------------------------------------------------------------------------------+
| Tableau candidatures                                                              |
| Offre | Entreprise | Statut | Date | Actions                                      |
+----------------------------------------------------------------------------------+
```

### 7.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre page                       |
| CTA retours                      |
+----------------------------------+
| Carte candidature 1              |
| offre / entreprise / statut      |
| date / actions                   |
+----------------------------------+
| Carte candidature 2              |
+----------------------------------+
```

### 7.6 Etats a designer

- etudiant avec plusieurs candidatures,
- aucun resultat,
- CV disponible,
- CV absent.

### 7.7 A ne pas inventer

- pas d'edition du statut si la fonctionnalite n'existe pas,
- pas de workflow d'acceptation/refus non defini.

## 8. Page `V-PIL-005` - Detail d'une candidature cote pilote

Route :
`/dashboard/pilote/candidatures/{id}`

### 8.1 But produit

Permettre au pilote de consulter le detail d'une candidature dans le contexte de supervision.

### 8.2 Contenu obligatoire

- titre base sur l'offre,
- meta entreprise / lieu / contrat,
- actions :
  - retour aux candidatures de l'etudiant,
  - voir l'offre,
  - telecharger le CV,
- bloc `Etudiant`,
- bloc `Suivi`,
- bloc `Lettre de motivation`.

### 8.3 Hierarchie visuelle

Ordre recommande :

1. contexte de candidature,
2. actions principales,
3. identite etudiant,
4. suivi,
5. lettre.

### 8.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Titre candidature + meta                                                          |
| actions                                                                           |
+-----------------------------------------+----------------------------------------+
| Bloc etudiant / suivi                   | actions document                       |
+-----------------------------------------+----------------------------------------+
| Lettre de motivation                                                             |
+----------------------------------------------------------------------------------+
```

### 8.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre + meta                     |
| actions                          |
+----------------------------------+
| Etudiant                         |
+----------------------------------+
| Suivi                            |
+----------------------------------+
| Lettre de motivation             |
+----------------------------------+
```

### 8.6 Etats a designer

- CV disponible,
- CV absent,
- lettre tres courte,
- lettre tres longue.

### 8.7 A ne pas inventer

- pas de bloc d'evaluation RH,
- pas de commentaires confidentiels,
- pas de changement de statut si non implemente.

## 9. Page `V-PIL-006` - Creation d'un compte etudiant

Route :
`/dashboard/pilote/etudiants/create`

### 9.1 But produit

Permettre au pilote de creer rapidement un compte etudiant rattache a sa promotion.

### 9.2 Contenu obligatoire

- titre `Creer un compte etudiant`,
- formulaire :
  - prenom,
  - nom,
  - email,
  - promotion en lecture seule,
  - mot de passe initial,
- erreurs inline,
- CTA `Creer le compte`,
- CTA `Annuler`.

### 9.3 Hierarchie visuelle

Ordre recommande :

1. titre et contexte,
2. informations identitaires,
3. promotion verrouillee,
4. mot de passe initial,
5. actions.

### 9.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Carte formulaire                                                                  |
| Titre                                                                             |
| Prenom                                                                            |
| Nom                                                                               |
| Email                                                                             |
| Promotion (disabled)                                                              |
| Mot de passe initial                                                              |
| [Creer le compte] [Annuler]                                                       |
+----------------------------------------------------------------------------------+
```

### 9.5 Structure mobile

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
| Promotion                        |
+----------------------------------+
| Mot de passe initial             |
+----------------------------------+
| CTA creer                        |
| CTA annuler                      |
+----------------------------------+
```

### 9.6 Etats a designer

- formulaire vide,
- erreurs champ,
- email deja pris,
- succes apres creation.

### 9.7 A ne pas inventer

- pas de choix manuel de promotion,
- pas de role selectionnable,
- pas de workflow invitation email si non prevu.

## 10. Page `V-PIL-007` - Edition d'un compte etudiant

Route :
`/dashboard/pilote/etudiants/{id}/edit`

### 10.1 But produit

Permettre au pilote de corriger ou mettre a jour les informations d'un etudiant existant.

### 10.2 Contenu obligatoire

- titre `Modifier un compte etudiant`,
- formulaire :
  - prenom,
  - nom,
  - email,
  - promotion en lecture seule,
  - nouveau mot de passe optionnel,
- erreurs inline,
- CTA `Enregistrer`,
- CTA `Annuler`.

### 10.3 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Carte formulaire                                                                  |
| Titre                                                                             |
| Prenom                                                                            |
| Nom                                                                               |
| Email                                                                             |
| Promotion (disabled)                                                              |
| Nouveau mot de passe (optionnel)                                                  |
| [Enregistrer] [Annuler]                                                           |
+----------------------------------------------------------------------------------+
```

### 10.4 Structure mobile

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
| Promotion                        |
+----------------------------------+
| Nouveau mot de passe             |
+----------------------------------+
| CTA enregistrer                  |
| CTA annuler                      |
+----------------------------------+
```

### 10.5 Etats a designer

- formulaire nominal,
- erreurs champ,
- mot de passe inchangé,
- mise a jour reussie.

### 10.6 A ne pas inventer

- pas de changement de role,
- pas de changement de promotion par le pilote,
- pas de bloc d'autorisations avance.

## 11. Regles de style pour l'espace pilote

L'espace pilote doit etre :

- plus structure que l'espace etudiant,
- plus oriente supervision,
- plus dense mais toujours lisible,
- plus institutionnel que marketing.

Le designer doit privilegier :

- une bonne lisibilite des tableaux,
- des cartes stats simples,
- des CTA de supervision nets,
- des parcours de retour clairs,
- une differentiation visuelle claire entre consultation et edition.

## 12. Definition of done du lot design pilote

Le lot est considere pret si :

- chaque page existe en desktop et mobile,
- les parcours `dashboard -> etudiants -> candidatures -> detail` sont evidents,
- les pages de creation et d'edition sont completement specifíees,
- les etats vides et erreurs existent,
- le perimetre pilote est clair sans confusion avec l'admin.

## 13. Suite recommandee

Apres ce document, la suite logique est :

1. pages administrateur,
2. pages de management CRUD,
3. pages systeme et support.
