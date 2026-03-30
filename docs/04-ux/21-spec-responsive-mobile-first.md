# Specification responsive mobile first

Ce document formalise le `Lot 7 - Responsive mobile first` de la phase `P4`.

Il definit les regles de mise en page et de comportement responsive pour les ecrans MVP afin de garantir une implementation robuste sur mobile et desktop.

## 1. Objectif

Rendre les parcours critiques utilisables sur petit ecran sans degradation majeure de comprehension, de navigation ou d'action.

## 2. Principes directeurs

- le mobile est la base de conception, pas une adaptation tardive,
- chaque ecran critique doit rester lisible et actionnable en une seule colonne,
- la priorite est donnee au contenu et a l'action principale,
- les tableaux doivent avoir une strategie mobile explicite,
- les filtres ne doivent jamais masquer le contenu principal de facon permanente,
- les messages systeme doivent rester proches de l'action qui les a declenches.

## 3. Breakpoints recommandes

Les valeurs exactes pourront etre ajustees en implementation, mais la logique suivante doit etre conservee :

- `XS` : jusqu'a `479px`
- `SM` : `480px` a `767px`
- `MD` : `768px` a `1023px`
- `LG` : `1024px` a `1439px`
- `XL` : `1440px` et plus

Regle de travail :

- concevoir d'abord `XS/SM`,
- stabiliser ensuite `MD`,
- raffiner `LG/XL` en dernier.

## 4. Largeurs et grille

### Conteneur principal

- mobile : largeur fluide avec marges laterales constantes
- tablette : largeur fluide avec marges accrues
- desktop : largeur max definie pour eviter des lignes trop longues

Recommendation :

- contenu standard : largeur max autour de `1200px`
- formulaires centres : largeur max plus etroite
- pages detail a deux colonnes : largeur max similaire mais avec ratio de colonnes controle

### Grille

- mobile : `1` colonne
- tablette : `2` colonnes possibles pour certains blocs
- desktop : `2` a `12` colonnes selon la complexite de la page

## 5. Espacements et zones interactives

- toute zone cliquable doit rester facile a toucher sur mobile,
- les boutons principaux doivent avoir une hauteur confortable,
- les liens proches les uns des autres doivent garder un espacement suffisant,
- les champs de formulaire doivent occuper toute la largeur utile sur mobile.

Regles minimales recommandees :

- cibles tactiles d'au moins `44px`
- espacement vertical plus important sur mobile que sur desktop
- pas de deux CTA critiques cote a cote si cela reduit la lisibilite

## 6. Regles responsive par famille de composants

### `HeaderPublic`

- desktop : navigation horizontale visible
- mobile : logo + bouton menu + acces rapide au CTA principal si necessaire
- ne jamais afficher une barre sur deux lignes qui casse la lecture

### `HeaderRole`

- desktop : barre haute + navigation de role claire
- mobile : barre haute compacte + menu declenchable
- l'action `Deconnexion` doit rester accessible sans recherche excessive

### `SidebarRole`

- desktop : colonne laterale persistante
- tablette : colonne compacte ou navigation superieure selon place disponible
- mobile : remplacee par un menu ou tiroir

### `DataTable`

- desktop : tableau classique
- tablette : tableau reduit si les colonnes restent lisibles
- mobile : conversion en cartes ou lignes empilees

Regle :

- ne pas conserver un tableau horizontal scrollable comme solution par defaut si l'information devient difficile a lire

### `Card`

- mobile : carte sur une colonne
- tablette : `2` colonnes possibles
- desktop : grille selon densite de contenu

### `Pagination`

- mobile : version simplifiee avec precedent / suivant et page courante
- desktop : pagination complete possible

### `Alert`

- pleine largeur du conteneur
- placee au-dessus du bloc concerne
- ne pas pousser l'action principale trop loin sous la ligne de flottaison

### Champs de formulaire

- mobile : `100%` largeur utile
- desktop : largeur controlee, sans lignes trop longues
- labels toujours au-dessus ou clairement associes, jamais tronques

### `PrimaryButton`

- mobile : largeur pleine ou tres visible selon contexte
- desktop : largeur adaptee au contenu

## 7. Regles responsive par famille d'ecrans

### 7.1 Pages publiques simples

Ecrans :

- accueil
- login
- pages erreur

Regles :

- une seule colonne sur mobile
- texte d'introduction court
- CTA principal visible sans scroll excessif
- footer compact sur petit ecran

### 7.2 Pages liste

Ecrans :

- liste des offres
- liste des entreprises
- liste des candidatures etudiant
- liste des etudiants pilote

Regles :

- filtres repliables sur mobile
- resume resultats au-dessus de la liste
- contenus en cartes sur mobile si le tableau devient trop dense
- pagination simplifiee sur petit ecran

### 7.3 Pages detail

Ecrans :

- detail offre
- detail entreprise

Regles :

- mobile : une colonne, avec l'action principale pres du haut
- desktop : deux colonnes possibles
- les meta informations ne doivent pas passer avant le titre et le contexte

### 7.4 Pages formulaire

Ecrans :

- login
- candidature
- creation de compte etudiant

Regles :

- empilement vertical strict sur mobile
- labels au-dessus des champs
- messages d'erreur immediatement visibles
- bouton primaire visible sans devoir faire un long aller-retour dans la page

### 7.5 Pages dashboard

Ecrans :

- dashboard pilote

Regles :

- mobile : cartes empilees
- tablette : grille simple
- desktop : grille plus riche
- les raccourcis essentiels doivent rester visibles en haut

## 8. Ordre de lecture mobile

L'ordre de lecture mobile doit rester coherent et utile.

Regles :

- contexte avant action,
- action principale avant contenus secondaires,
- messages avant formulaire si le message concerne le formulaire,
- titre avant meta informations,
- resume avant details longs,
- liste avant pagination.

Exemple detail offre :

1. titre
2. resume
3. CTA principal
4. meta informations
5. description
6. competences
7. informations entreprise

## 9. Comportement des filtres sur mobile

- les filtres doivent pouvoir etre masques et affiches facilement,
- un indicateur clair doit montrer que des filtres sont actifs,
- l'action `Appliquer` ou le filtrage dynamique doit etre explicite,
- l'utilisateur doit pouvoir revenir vite au contenu resultats.

Cas a eviter :

- un panneau de filtres permanent qui pousse la liste trop bas,
- des champs de filtre disperses dans plusieurs zones sans structure.

## 10. Comportement des tableaux sur mobile

Strategie recommandee :

- transformer en cartes,
- ou empiler les colonnes en paires `label / valeur`.

Exemple candidature mobile :

- offre
- entreprise
- date
- statut
- action

Chaque carte doit garder une hierarchie stable et une action clairement visible.

## 11. Comportement des formulaires longs sur mobile

- regrouper les champs par blocs logiques,
- eviter les sections trop longues sans respiration,
- conserver le message d'erreur proche du champ,
- eviter les doubles colonnes,
- afficher le bouton principal a la fin du bloc formulaire avec espacement suffisant.

## 12. Regles de performance percue

- reserver l'espace des contenus en chargement,
- eviter les sauts de layout quand un message apparait,
- ne pas charger un header trop dense sur mobile,
- prioriser le rendu du contenu principal avant les enrichissements secondaires.

## 13. Cas critiques a verifier

- login sur petit ecran
- application a une offre sur mobile
- lecture du detail offre sans perdre le CTA
- liste d'etudiants pilote sur tablette
- page `403` sur mobile
- filtres offres sur mobile

## 14. Definition of Done du Lot 7

Le `Lot 7` est considere comme exploitable si :

- les breakpoints de travail sont definis,
- chaque famille d'ecrans a une regle mobile claire,
- les tableaux ont une strategie mobile explicite,
- les formulaires ont une structure mobile definie,
- les CTA restent accessibles sur petit ecran,
- les parcours critiques restent utilisables de bout en bout sur mobile.
