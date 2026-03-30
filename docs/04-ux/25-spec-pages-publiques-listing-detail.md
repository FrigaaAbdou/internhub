# Specification detaillee - Pages publiques listing et detail

Ce document sert de handoff direct pour le web designer.

Il couvre les pages publiques au-dela de la homepage, c'est-a-dire les pages de consultation qui structurent la decouverte du produit :

- liste des offres,
- detail d'une offre,
- liste des entreprises,
- detail d'une entreprise.

Objectif :
eviter au designer de repartir de zero.

Le document decrit, pour chaque page :

- son objectif exact,
- son audience,
- son contenu obligatoire,
- sa hierarchie visuelle,
- sa structure desktop et mobile,
- ses etats,
- ses variations selon le role,
- les points a ne pas inventer.

## 1. Sources de verite

Les decisions de ce document s'appuient sur :

- [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md)
- [16-navigation-et-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/16-navigation-et-parcours.md)
- [18-wireframes-structurels-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/18-wireframes-structurels-mvp.md)
- [19-systeme-composants-ui.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/19-systeme-composants-ui.md)
- [20-matrice-etats-formulaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/20-matrice-etats-formulaires.md)
- [21-spec-responsive-mobile-first.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/21-spec-responsive-mobile-first.md)
- [22-accessibilite-integree.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/22-accessibilite-integree.md)
- [03-referentiel-fonctionnel.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/03-referentiel-fonctionnel.md)

## 2. Regles de cadrage a respecter

Le designer ne doit pas supposer un produit different de celui qui existe.

Contraintes produit :

- pas d'inscription publique etudiante,
- les pages publiques doivent rester consultables sans connexion,
- le role etudiant voit des CTA de candidature ou de wishlist seulement s'il est connecte,
- un visiteur non connecte peut consulter mais pas agir,
- les pages ne sont pas des dashboards admin deguisés,
- les pages doivent vendre la clarté du produit sans mentir sur les fonctionnalites.

Contraintes UX :

- mobile first,
- lisibilite immediate du contenu principal,
- filtre et navigation compréhensibles sans effort,
- CTA principal unique par zone,
- etats vides et etats de recherche inclus des le design,
- pas de surcharge decorative sur les pages data-heavy.

## 3. Bloc commun aux pages publiques de consultation

Toutes les pages de cette famille doivent partager la meme logique de composition.

### 3.1 Header

Contenu obligatoire :

- logo InternHub,
- navigation publique,
- acces connexion si visiteur,
- acces role si utilisateur connecte.

Comportement :

- discret,
- stable,
- non envahissant,
- toujours secondaire par rapport au contenu de la page.

### 3.2 Intro de page

Chaque page doit commencer par une zone d'introduction.

Contenu attendu :

- eyebrow ou label de contexte,
- titre de page fort,
- phrase de clarification courte,
- eventuellement un bloc d'indicateurs ou de reassurance.

Cette zone ne doit pas prendre tout l'ecran.
Elle doit cadrer la page, pas la remplacer.

### 3.3 Contenu principal

Le contenu principal doit etre structure en sections nettes :

- recherche / filtres,
- resultats,
- contenu detail,
- navigation secondaire ou actions associees,
- pagination ou liens de retour.

### 3.4 Footer

Footer simple avec :

- liens utiles,
- mentions legales,
- contact,
- coherence de marque.

## 4. Page `V-PUB-005` - Liste des offres

Route :
`/offres`

### 4.1 But produit

Permettre a un visiteur ou a un etudiant de trouver rapidement une opportunite de stage pertinente.

Cette page doit faire deux choses en meme temps :

- rassurer sur la richesse de l'offre,
- simplifier la recherche concrète.

### 4.2 Audience

- visiteur anonyme,
- etudiant connecte,
- pilote ou administrateur en mode consultation.

### 4.3 Message principal

InternHub centralise les opportunites et rend la recherche plus lisible.

La page doit donner l'impression que :

- les offres sont reelles,
- la recherche est simple,
- la plateforme est organisee,
- l'utilisateur sait ou cliquer ensuite.

### 4.4 Contenu obligatoire

Bloc hero / intro :

- titre de page fort,
- phrase de promesse,
- illustration ou visuel editorial si conserve,
- indicateurs synthétiques comme nombre d'offres et nombre d'entreprises.

Bloc recherche / filtres :

- champ recherche principal,
- filtre localisation,
- filtre type de contrat,
- CTA d'application des filtres,
- CTA de reset.

Bloc resultats :

- titre de section du type `Offres disponibles` ou `Internships available`,
- resume de resultats,
- grille ou liste de cartes offres,
- pagination.

Bloc contenu complementaire optionnel mais recommande :

- regroupement par ville,
- regroupement par type de contrat,
- bloc de reassurance sur la qualite des offres,
- mini section `how it works`.

### 4.5 Hierarchie visuelle

Ordre visuel recommande :

1. titre / promesse,
2. barre de recherche,
3. cartes offres,
4. filtres secondaires ou contenus de reassurance,
5. pagination.

La recherche doit etre plus visible que les statistiques.
Les cartes offres doivent etre plus visibles que les blocs marketing secondaires.

### 4.6 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header public                                                                    |
+----------------------------------------------------------------------------------+
| Intro page: eyebrow + H1 + texte + statistiques + illustration                  |
+----------------------------------------------------------------------------------+
| Barre recherche / filtres                                                        |
| [search................................] [ville] [contrat] [apply] [reset]      |
+----------------------------------------------------------------------------------+
| Resume resultats + tri/eventuelle meta                                           |
+----------------------------------------------------------------------------------+
| Grille de cartes offres                                                          |
| [Carte 1] [Carte 2] [Carte 3]                                                    |
| [Carte 4] [Carte 5] [Carte 6]                                                    |
| [Carte 7] [Carte 8] [Carte 9]                                                    |
+----------------------------------------------------------------------------------+
| Pagination                                                                       |
+----------------------------------------------------------------------------------+
| Sections complementaires                                                         |
| villes / entreprises / process / reassurance                                     |
+----------------------------------------------------------------------------------+
| Footer                                                                           |
+----------------------------------------------------------------------------------+
```

### 4.7 Structure mobile

```text
+----------------------------------+
| Header compact                   |
+----------------------------------+
| Intro page                       |
| eyebrow                          |
| H1                               |
| texte                            |
| stats                            |
+----------------------------------+
| Recherche                        |
| [search........................] |
| [ville........................]  |
| [contrat......................]  |
| [apply] [reset]                 |
+----------------------------------+
| Resume resultats                 |
+----------------------------------+
| Carte offre 1                    |
+----------------------------------+
| Carte offre 2                    |
+----------------------------------+
| Carte offre 3                    |
+----------------------------------+
| Pagination                       |
+----------------------------------+
| Sections complementaires         |
+----------------------------------+
| Footer                           |
+----------------------------------+
```

### 4.8 Structure d'une carte offre

Contenu obligatoire :

- identifiant visuel entreprise ou initials,
- titre de l'offre,
- nom entreprise,
- lieu,
- type de contrat,
- courte description,
- tags competences si disponibles,
- date ou fraicheur de publication,
- CTA `Voir le detail`.

Si l'utilisateur est etudiant connecte, un CTA secondaire de wish-list peut exister dans une variante, mais il ne doit pas surcharger la carte.

### 4.9 Etats a designer

- page nominale avec beaucoup de resultats,
- page avec peu de resultats,
- aucun resultat,
- recherche texte active,
- filtres actifs,
- pagination active,
- utilisateur connecte etudiant,
- visiteur non connecte.

### 4.10 A ne pas inventer

- pas de tri complexe non prevu par le produit,
- pas de comparateur multi-offres,
- pas de notation publique des offres,
- pas de CTA d'inscription publique,
- pas de wording qui promet une IA ou un matching avance non implemente.

## 5. Page `V-PUB-006` - Detail d'une offre

Route :
`/offres/{id}`

### 5.1 But produit

Permettre a l'utilisateur de comprendre une offre rapidement et de prendre la bonne action :

- postuler s'il est etudiant,
- se connecter s'il est visiteur,
- consulter l'entreprise associee,
- revenir a la liste sans perte de contexte.

### 5.2 Audience

- visiteur,
- etudiant,
- pilote/admin en consultation,
- eventuellement pilote/admin en edition via action secondaire.

### 5.3 Message principal

Cette page doit inspirer confiance et clarifier la decision.

L'utilisateur doit repondre facilement a trois questions :

- de quel stage s'agit-il,
- dans quelle entreprise,
- quelle action dois-je prendre maintenant.

### 5.4 Contenu obligatoire

Bloc hero detail :

- titre de l'offre,
- nom entreprise,
- localisation,
- type de contrat,
- statut de visibilite si besoin cote management,
- CTA principal contextuel.

Bloc contenu descriptif :

- description complete,
- competences ou tags,
- eventuelles informations de contexte.

Bloc actions :

- retour a la liste,
- voir l'entreprise,
- postuler si etudiant,
- se connecter pour postuler si visiteur,
- ajouter/retirer de la wishlist si etudiant.

Bloc entreprise associee :

- mini carte entreprise,
- lien vers la fiche entreprise.

Bloc navigation contextuelle :

- retour liste,
- eventuels liens vers autres offres similaires si un jour ajoute.

### 5.5 Hierarchie visuelle

Ordre visuel recommande :

1. titre + metadata essentielles,
2. CTA principal,
3. description,
4. bloc entreprise,
5. actions secondaires.

La candidature doit etre clairement visible sans rendre la page agressive.

### 5.6 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header public                                                                    |
+----------------------------------------------------------------------------------+
| Breadcrumb / retour liste                                                        |
+----------------------------------------------------------------------------------+
| Hero detail                                                                      |
| Titre offre                                                                      |
| Entreprise · lieu · contrat                                                      |
| CTA principal: postuler / se connecter                                           |
| CTA secondaires: entreprise / wishlist / retour                                  |
+-----------------------------------------+----------------------------------------+
| Description detaillee                   | Aside                                  |
| missions, contexte, attendus            | carte entreprise                       |
| competences, tags                       | actions secondaires                    |
+-----------------------------------------+----------------------------------------+
| Footer                                                                          |
+----------------------------------------------------------------------------------+
```

### 5.7 Structure mobile

```text
+----------------------------------+
| Header compact                   |
+----------------------------------+
| Retour liste                     |
+----------------------------------+
| Titre offre                      |
| entreprise / lieu / contrat      |
| CTA principal                    |
| CTA secondaire                   |
+----------------------------------+
| Description                      |
+----------------------------------+
| Competences / tags               |
+----------------------------------+
| Carte entreprise associee        |
+----------------------------------+
| Footer                           |
+----------------------------------+
```

### 5.8 Etats a designer

- visiteur non connecte,
- etudiant connecte non encore candidat,
- etudiant connecte deja wishliste,
- pilote/admin avec action modifier visible,
- offre longue avec beaucoup de texte,
- offre courte avec peu de texte.

### 5.9 Variations par role

Visiteur :

- CTA principal `Se connecter pour postuler`

Etudiant :

- CTA principal `Postuler`
- CTA wish-list visible

Pilote / Administrateur :

- pas de CTA candidature
- CTA modification possible si la page l'autorise

### 5.10 A ne pas inventer

- pas de formulaire de candidature inline sur la page detail,
- pas de chat avec l'entreprise,
- pas d'informations RH non disponibles,
- pas de faux badges de priorite non relies au produit.

## 6. Page `V-PUB-007` - Liste des entreprises

Route :
`/entreprises`

### 6.1 But produit

Permettre de parcourir le reseau d'entreprises referencees et de comprendre rapidement leur positionnement.

Cette page doit vendre la credibilite de la plateforme par la qualite des entreprises presentes.

### 6.2 Audience

- visiteur,
- etudiant,
- pilote,
- administrateur.

### 6.3 Message principal

InternHub ne montre pas seulement des offres ; la plateforme structure aussi l'ecosysteme entreprises.

### 6.4 Contenu obligatoire

- intro de page,
- champ recherche entreprise,
- resume de resultats,
- grille ou liste de cartes entreprises,
- lien vers detail entreprise,
- pagination.

### 6.5 Contenu d'une carte entreprise

- nom entreprise,
- secteur,
- ville,
- description courte,
- CTA `Voir la fiche`.

Optionnel si les donnees sont disponibles plus tard :

- nombre d'offres actives,
- site web,
- logo.

### 6.6 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header public                                                                    |
+----------------------------------------------------------------------------------+
| Intro page: titre + texte                                                        |
+----------------------------------------------------------------------------------+
| Barre de recherche                                                               |
| [search..................................................] [filter]             |
+----------------------------------------------------------------------------------+
| Resume resultats                                                                 |
+----------------------------------------------------------------------------------+
| Grille cartes entreprises                                                        |
| [Entreprise 1] [Entreprise 2]                                                    |
| [Entreprise 3] [Entreprise 4]                                                    |
+----------------------------------------------------------------------------------+
| Pagination                                                                       |
+----------------------------------------------------------------------------------+
| Footer                                                                           |
+----------------------------------------------------------------------------------+
```

### 6.7 Structure mobile

```text
+----------------------------------+
| Header compact                   |
+----------------------------------+
| Intro page                       |
+----------------------------------+
| Recherche                        |
| [search.......................]  |
| [filter]                        |
+----------------------------------+
| Resume resultats                 |
+----------------------------------+
| Carte entreprise 1               |
+----------------------------------+
| Carte entreprise 2               |
+----------------------------------+
| Pagination                       |
+----------------------------------+
| Footer                           |
+----------------------------------+
```

### 6.8 Etats a designer

- nominal,
- recherche active,
- aucun resultat,
- pagination,
- mode avec acces management secondaire visible.

### 6.9 A ne pas inventer

- pas de classement star/rating si non defini,
- pas de carrousel logos artificiel,
- pas de promesse `trusted by` fictive si elle n'est pas justifiee.

## 7. Page `V-PUB-008` - Detail d'une entreprise

Route :
`/entreprises/{id}`

### 7.1 But produit

Permettre a l'utilisateur de comprendre une entreprise et de naviguer ensuite vers ses offres actives.

Cette page doit servir de fiche societe claire et sobre.

### 7.2 Audience

- visiteur,
- etudiant,
- pilote,
- administrateur.

### 7.3 Message principal

L'entreprise est credible, identifiable, et rattachee a de vraies opportunites.

### 7.4 Contenu obligatoire

Bloc hero detail :

- nom entreprise,
- secteur,
- ville,
- lien site web si disponible,
- CTA retour liste.

Bloc presentation :

- description complete entreprise.

Bloc offres associees :

- liste des offres publiees de l'entreprise,
- lien vers chaque detail d'offre.

Bloc action management eventuel :

- bouton modifier si role autorise.

### 7.5 Hierarchie visuelle

Ordre recommande :

1. identite entreprise,
2. description,
3. offres associees,
4. actions secondaires.

Les offres associees doivent etre clairement visibles mais ne pas prendre le dessus sur l'identite entreprise.

### 7.6 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header public                                                                    |
+----------------------------------------------------------------------------------+
| Retour liste                                                                     |
+----------------------------------------------------------------------------------+
| Hero detail entreprise                                                           |
| Nom | secteur | ville | site web                                                 |
| CTA retour / CTA edition si autorise                                             |
+-----------------------------------------+----------------------------------------+
| Description complete                    | Aside contextuel                       |
| presentation entreprise                 | liens utiles / meta                    |
+-----------------------------------------+----------------------------------------+
| Section offres publiees                                                           |
| [Offre 1]                                                                         |
| [Offre 2]                                                                         |
| [Offre 3]                                                                         |
+----------------------------------------------------------------------------------+
| Footer                                                                           |
+----------------------------------------------------------------------------------+
```

### 7.7 Structure mobile

```text
+----------------------------------+
| Header compact                   |
+----------------------------------+
| Retour liste                     |
+----------------------------------+
| Nom entreprise                   |
| secteur / ville                  |
| site web                         |
| CTA retour                       |
+----------------------------------+
| Description                      |
+----------------------------------+
| Offres publiees                  |
| lien offre 1                     |
| lien offre 2                     |
| lien offre 3                     |
+----------------------------------+
| Footer                           |
+----------------------------------+
```

### 7.8 Etats a designer

- entreprise avec plusieurs offres,
- entreprise sans offre active,
- entreprise avec site web,
- entreprise sans site web,
- admin/pilote avec action modifier.

### 7.9 A ne pas inventer

- pas de fiche corporate trop lourde,
- pas de galerie medias fictive,
- pas d'avis utilisateurs publics si la fonctionnalite n'est pas definie,
- pas de bloc `careers` separe si seules les offres InternHub existent.

## 8. Regles de style pour le designer

Direction generale recommandee :

- moderne,
- clair,
- credible,
- structure,
- peu de bruit visuel,
- accent violet utilise avec retenue.

Sur cette famille de pages :

- privilegier la lisibilite du contenu,
- utiliser les cartes avec parcimonie,
- eviter les sections purement decoratives qui repoussent l'information utile,
- maintenir une distinction claire entre intro, data, CTA et contenu secondaire.

## 9. Definition of done de ce lot design

Le lot pourra etre considere pret pour integration si :

- chaque page a une version desktop et mobile,
- les blocs obligatoires sont presents,
- les etats vides et resultats nuls sont designes,
- les CTA varient selon le role sans contradiction avec le produit,
- la hierarchie visuelle guide clairement l'action principale,
- les structures peuvent etre remises a un dev sans interpretation fonctionnelle supplementaire.

## 10. Suite recommandee

Apres ce document, la suite logique est :

1. pages etudiant,
2. pages pilote,
3. pages administrateur et management,
4. pages systeme et support.
