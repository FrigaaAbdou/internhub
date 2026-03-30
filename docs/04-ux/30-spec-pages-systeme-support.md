# Specification detaillee - Pages systeme et support

Ce document sert de handoff direct pour le web designer sur les pages systeme et support.

Il couvre les pages qui ne sont ni des modules metier centraux, ni des dashboards de role, mais qui jouent un role critique dans la perception de qualite du produit.

Pages couvertes :

- statistiques publiques,
- mentions legales,
- page `403`,
- page `404`,
- page `500`.

Objectif :
eviter que ces pages soient traitees comme des fins de projet ou comme des ecrans techniques sans intention UX.

## 1. Sources de reference

Ce document s'appuie sur :

- [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md)
- [16-navigation-et-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/16-navigation-et-parcours.md)
- [18-wireframes-structurels-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/18-wireframes-structurels-mvp.md)
- [19-systeme-composants-ui.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/19-systeme-composants-ui.md)
- [20-matrice-etats-formulaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/20-matrice-etats-formulaires.md)
- [21-spec-responsive-mobile-first.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/21-spec-responsive-mobile-first.md)
- [22-accessibilite-integree.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/22-accessibilite-integree.md)
- [18-stabilisation-erreurs-repli-p8.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/18-stabilisation-erreurs-repli-p8.md)
- [21-mentions-legales-meta-hygiene-p8.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/21-mentions-legales-meta-hygiene-p8.md)

## 2. Regles de cadrage

Ces pages doivent donner une impression de finition.

Elles ne doivent pas etre considerees comme secondaires d'un point de vue experience.
Dans un produit defendu devant un jury, un client ou un utilisateur, ce sont souvent ces pages qui donnent l'impression de maturite ou au contraire d'improvisation.

### 2.1 Rôle de ces pages

- rassurer,
- cadrer,
- expliquer,
- recuperer une erreur,
- montrer que le produit est tenu proprement.

### 2.2 Ce qu'elles ne doivent pas devenir

- des pages vides avec un seul bloc de texte mal pose,
- des ecrans techniques trop bruts,
- des pages marketing surjouees,
- des cul-de-sac sans action de retour.

## 3. Shell commun

### 3.1 Pages support

Pour `statistiques` et `mentions legales` :

- header public ou protege selon contexte global,
- intro de page claire,
- contenu principal bien structure,
- footer.

### 3.2 Pages systeme d'erreur

Pour `403`, `404`, `500` :

- code erreur visible,
- titre clair,
- phrase d'explication humaine,
- CTA de sortie,
- presentation simple mais soignee.

## 4. Page `V-PUB-011` / Statistiques publiques

Route :
`/statistiques`

### 4.1 But produit

Permettre de consulter des indicateurs globaux anonymises sur l'activite de la plateforme.

Cette page doit inspirer :

- transparence,
- lisibilite,
- sobriete,
- credibilite.

### 4.2 Audience

- public,
- etudiant,
- pilote,
- administrateur.

### 4.3 Contenu obligatoire

- titre de page,
- texte d'introduction sur l'anonymisation,
- cartes statistiques principales,
- bloc `Indicateurs exploitables`,
- bloc `Repartition des candidatures`.

### 4.4 Cartes statistiques attendues

- offres publiees,
- entreprises referencees,
- candidatures deposees,
- moyenne candidatures / offre.

### 4.5 Blocs analytiques attendus

- offres par ville,
- offres par type de contrat,
- repartition des candidatures par statut.

### 4.6 Hierarchie visuelle

Ordre recommande :

1. contexte de la page,
2. cartes stats globales,
3. indicateurs par categorie,
4. repartition de candidatures.

La page doit etre plus data-driven que marketing, mais rester tres lisible.

### 4.7 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header public ou protege                                                          |
+----------------------------------------------------------------------------------+
| Eyebrow statistiques + titre + texte de contexte                                  |
+----------------------------------------------------------------------------------+
| Cartes statistiques                                                                |
| [Offres] [Entreprises] [Candidatures] [Moyenne / offre]                           |
+----------------------------------------------------------------------------------+
| Indicateurs exploitables                                                          |
| [Offres par ville] [Offres par type de contrat]                                   |
+----------------------------------------------------------------------------------+
| Repartition des candidatures                                                      |
+----------------------------------------------------------------------------------+
| Footer                                                                           |
+----------------------------------------------------------------------------------+
```

### 4.8 Structure mobile

```text
+----------------------------------+
| Header                           |
+----------------------------------+
| Titre + intro                    |
+----------------------------------+
| Carte stat 1                     |
+----------------------------------+
| Carte stat 2                     |
+----------------------------------+
| Carte stat 3                     |
+----------------------------------+
| Carte stat 4                     |
+----------------------------------+
| Bloc metrique 1                  |
+----------------------------------+
| Bloc metrique 2                  |
+----------------------------------+
| Repartition candidatures         |
+----------------------------------+
| Footer                           |
+----------------------------------+
```

### 4.9 Etats a designer

- page nominale,
- aucune offre publiee,
- aucune candidature,
- sections avec donnees partielles.

### 4.10 A ne pas inventer

- pas de graphiques complexes si les donnees ne les justifient pas,
- pas d'indicateurs individuels,
- pas de comparaison fictive dans le temps si non calculee.

## 5. Page - Mentions legales

Route :
`/mentions-legales`

### 5.1 But produit

Poser un cadre legal minimal et propre pour la version de demonstration.

La page doit etre rassurante, lisible et institutionnelle.

### 5.2 Contenu obligatoire

- titre `Mentions legales`,
- texte d'introduction,
- bloc `Editeur`,
- bloc `Hebergement`,
- bloc `Donnees personnelles`,
- bloc `Propriete intellectuelle`.

### 5.3 Hierarchie visuelle

Ordre recommande :

1. titre + contexte,
2. cartes ou blocs legaux bien separes,
3. contenu informatif secondaire.

Le ton doit etre serieux, mais pas austere au point de sembler juridique brut.

### 5.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header                                                                           |
+----------------------------------------------------------------------------------+
| Intro page : titre + texte de contexte                                            |
+----------------------------------------------------------------------------------+
| Grille de blocs                                                                    |
| [Editeur] [Hebergement]                                                           |
| [Donnees personnelles] [Propriete intellectuelle]                                |
+----------------------------------------------------------------------------------+
| Footer                                                                           |
+----------------------------------------------------------------------------------+
```

### 5.5 Structure mobile

```text
+----------------------------------+
| Header                           |
+----------------------------------+
| Titre + intro                    |
+----------------------------------+
| Bloc editeur                     |
+----------------------------------+
| Bloc hebergement                 |
+----------------------------------+
| Bloc donnees personnelles        |
+----------------------------------+
| Bloc propriete intellectuelle    |
+----------------------------------+
| Footer                           |
+----------------------------------+
```

### 5.6 Etats a designer

- page nominale,
- textes longs,
- contact email visible.

### 5.7 A ne pas inventer

- pas de politique RGPD complete si elle n'existe pas encore,
- pas de jargon legal excessif inutile,
- pas de faux labels de conformite.

## 6. Page `403` - Acces refuse

### 6.1 But produit

Expliquer clairement a l'utilisateur qu'il n'a pas acces a la ressource, sans l'abandonner.

### 6.2 Contenu obligatoire

- code erreur,
- titre `Acces refuse`,
- phrase explicative,
- CTA principal,
- idealement CTA secondaire de retour contexte si disponible plus tard.

### 6.3 Hierarchie visuelle

Ordre recommande :

1. code erreur,
2. titre,
3. explication,
4. action de sortie.

### 6.4 Structure desktop et mobile

```text
+----------------------------------+
| Code erreur                      |
| Titre                            |
| Explication                      |
| CTA retour                       |
+----------------------------------+
```

### 6.5 Etats a designer

- visiteur non connecte,
- utilisateur connecte sans droit,
- message generique.

### 6.6 A ne pas inventer

- pas de texte culpabilisant,
- pas de ton agressif,
- pas de jargon technique.

## 7. Page `404` - Ressource introuvable

### 7.1 But produit

Indiquer que la ressource n'existe pas ou n'est plus disponible, avec une sortie simple.

### 7.2 Contenu obligatoire

- code erreur,
- titre `Ressource introuvable`,
- explication courte,
- CTA retour accueil,
- eventuellement CTA retour liste si contexte connu plus tard.

### 7.3 Structure desktop et mobile

```text
+----------------------------------+
| Code erreur                      |
| Titre                            |
| Explication                      |
| CTA retour                       |
+----------------------------------+
```

### 7.4 Etats a designer

- page generique,
- contexte connu avec retour liste.

### 7.5 A ne pas inventer

- pas d'humour excessif,
- pas de page vide minimaliste sans solution de retour.

## 8. Page `500` - Erreur technique

### 8.1 But produit

Signaler une erreur systeme de maniere propre et rassurante.

### 8.2 Contenu obligatoire

- code erreur,
- titre `Erreur technique`,
- message humain,
- CTA retour accueil,
- zone trace technique uniquement si contexte debug.

### 8.3 Hierarchie visuelle

Ordre recommande :

1. code erreur,
2. titre,
3. explication,
4. CTA,
5. details techniques en dernier et tres secondaires.

### 8.4 Structure desktop et mobile

```text
+----------------------------------+
| Code erreur                      |
| Titre                            |
| Message humain                   |
| CTA retour                       |
| Details techniques optionnels    |
+----------------------------------+
```

### 8.5 Etats a designer

- version utilisateur standard,
- version debug avec trace visible.

### 8.6 A ne pas inventer

- pas d'affichage technique trop agressif en version normale,
- pas de vocabulaire anxiogène,
- pas de detail stack trace mis en avant.

## 9. Regles de style pour les pages systeme/support

Ces pages doivent etre :

- simples,
- propres,
- rassurantes,
- finies.

Le designer doit privilegier :

- une typographie claire,
- de l'espace blanc,
- des blocs bien separes,
- un ou deux CTA maximum,
- une coherence totale avec le reste du produit.

## 10. Definition of done du lot design systeme/support

Le lot est considere pret si :

- chaque page existe en desktop et mobile,
- les messages sont humains et clairs,
- les pages d'erreur ont une vraie strategie de retour,
- les pages support ne ressemblent pas a des placeholders,
- la page statistiques est lisible meme avec peu de donnees.

## 11. Conclusion du package designer

Avec ce document, le package de handoff couvre maintenant :

- les pages publiques de listing et detail,
- les pages etudiant,
- les pages pilote,
- les pages administrateur,
- les pages CRUD,
- les pages systeme et support.

La suite n'est donc plus la production de nouveaux specs majeurs, mais :

1. la consolidation transversale du langage visuel,
2. la priorisation de design page par page,
3. la production effective des maquettes.
