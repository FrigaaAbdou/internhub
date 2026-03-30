# Systeme de composants UI

Ce document formalise le `Lot 5 - Systeme de composants` de la phase `P4`.

Il definit le langage d'interface reutilisable qui devra etre applique sur les ecrans MVP avant toute implementation.

## 1. Objectif

Eviter qu'une meme intention UX soit codee de plusieurs manieres differentes selon les pages.

Le systeme de composants doit permettre :

- la coherence visuelle et fonctionnelle,
- la reduction du temps d'integration,
- la reutilisation des comportements,
- la limitation des regressions de layout,
- une meilleure accessibilite par standardisation.

## 2. Regles globales

- chaque composant doit avoir un role unique clairement defini,
- chaque composant doit avoir des variantes limites et nommees,
- chaque composant doit expliciter ses etats interactifs,
- chaque composant doit preciser son usage interdit,
- chaque composant doit fonctionner sur mobile et desktop,
- chaque composant interactif doit rester utilisable au clavier,
- les composants doivent rester compatibles avec les permissions et les differences de role.

## 3. Familles de composants

### 3.1 Navigation et structure

#### `HeaderPublic`

Role :
naviguer entre les pages publiques.

Variantes :

- desktop complet
- mobile compact avec menu

Etats :

- visiteur
- utilisateur connecte

Regles de placement :

- en haut de toutes les pages publiques
- peut etre reutilise sur les pages detail publiques

Contraintes responsive :

- passer en barre compacte sur mobile
- le CTA principal reste visible ou accessible en 1 interaction maximum

Contraintes accessibilite :

- liens clairement intitules
- ordre de tabulation logique
- indicateur de focus visible

Cas interdits :

- afficher des actions protegees sans passer par la logique de role

#### `HeaderRole`

Role :
fournir la navigation principale des espaces proteges.

Variantes :

- etudiant
- pilote
- administrateur

Etats :

- nominal
- menu mobile ouvert
- item actif

Regles de placement :

- en haut de toutes les vues protegees

Cas interdits :

- afficher des liens vers des zones non autorisees par la matrice

#### `SidebarRole`

Role :
offrir des raccourcis persistants dans les espaces dashboard.

Variantes :

- pilote
- administrateur

Etats :

- item actif
- item inactif
- item desactive si fonctionnalite hors MVP

Regles de placement :

- a gauche en desktop
- remplacee par menu mobile sur petit ecran

#### `Footer`

Role :
porter les liens secondaires et mentions de bas de page.

Variantes :

- complet
- compact

Cas interdits :

- surcharger le footer avec des CTA principaux

### 3.2 Champs et formulaires

#### `TextField`

Role :
saisir une valeur textuelle simple.

Variantes :

- standard
- avec aide
- avec erreur

Etats :

- vide
- focus
- rempli
- invalide
- desactive

Regles de placement :

- 1 label par champ
- aide et erreur sous le champ

#### `EmailField`

Role :
saisie email avec validation specifique.

Evenements obligatoires :

- validation format
- message email invalide

#### `PasswordField`

Role :
saisie mot de passe.

Variantes :

- masque
- visible si bouton afficher est retenu

Contraintes accessibilite :

- label explicite
- indication du role du champ

#### `SelectField`

Role :
selection d'une option contrainte.

Usage principal :

- promo
- filtres

Cas interdits :

- remplacer un texte libre si l'option n'est pas vraiment contrainte

#### `TextareaField`

Role :
saisie longue.

Usage principal :

- lettre de motivation si champ texte retenu

#### `FileUploadField`

Role :
televerser un document.

Usage principal :

- CV

Etats :

- vide
- fichier choisi
- fichier refuse
- upload en cours
- succes

Messages obligatoires :

- format refuse
- taille refusee
- fichier manquant

### 3.3 Actions

#### `PrimaryButton`

Role :
porter l'action principale d'une vue ou d'un formulaire.

Variantes :

- action positive
- soumission

Etats :

- normal
- hover
- focus
- loading
- disabled

Cas interdits :

- deux boutons primaires concurrents dans la meme zone d'action

#### `SecondaryButton`

Role :
porter une action de soutien ou de retour.

Usage principal :

- annuler
- retour
- voir plus

#### `DangerButton`

Role :
porter une action destructive.

Usage principal :

- suppression

Cas interdits :

- utiliser ce bouton pour des actions non destructives

#### `LinkAction`

Role :
naviguer sans ambiguite.

Usage principal :

- retour liste
- ouvrir detail

### 3.4 Listes et contenus

#### `Card`

Role :
presenter un contenu unitaire synthétique.

Variantes :

- carte offre
- carte entreprise
- carte KPI

Regles de placement :

- utiliser pour listes mobiles ou contenus synthétiques

#### `DataTable`

Role :
afficher des listes comparables sur desktop.

Usage principal :

- candidatures
- etudiants

Etats :

- nominal
- vide
- chargement
- erreur

Responsive :

- bascule en cartes ou lignes empilees sur mobile si necessaire

#### `Pagination`

Role :
permettre la navigation dans les listes longues.

Etats :

- premiere page
- page intermediaire
- derniere page
- desactive

Cas interdits :

- pagination sans indication du contexte ou du nombre de resultats

### 3.5 Statut et feedback

#### `StatusBadge`

Role :
indiquer un statut compact.

Usage principal :

- statut candidature
- statut compte

Contraintes accessibilite :

- ne jamais coder l'information uniquement par couleur

#### `Alert`

Role :
porter un message systeme.

Variantes :

- succes
- erreur
- information
- avertissement

Etats :

- visible
- dismissable si retenu

Regles de placement :

- au-dessus du contenu concerne
- ou directement au-dessus du formulaire concerne

#### `EmptyState`

Role :
gérer les ecrans ou listes sans contenu.

Blocs minimum :

- titre
- explication
- action de sortie ou de creation si pertinente

#### `LoadingState`

Role :
indiquer qu'un contenu est en chargement.

Regle :

- reserver l'espace pour eviter un saut brutal de layout

### 3.6 Confirmation

#### `ConfirmationModal`

Role :
confirmer une action irreversible si ce pattern est retenu.

Usage principal :

- suppression
- sortie sans sauvegarde

Cas interdits :

- confirmation de toute action triviale

## 4. Matrice d'usage rapide

| Composant | Ecrans MVP principaux |
| --- | --- |
| `HeaderPublic` | accueil, login, offres, entreprises, pages erreur |
| `HeaderRole` | candidature, candidatures etudiant, dashboard pilote, etudiants pilote |
| `SidebarRole` | dashboard pilote, liste etudiants, candidatures pilote, creation compte etudiant |
| `TextField` | login, creation compte etudiant |
| `EmailField` | login, creation compte etudiant |
| `PasswordField` | login, creation compte etudiant |
| `SelectField` | filtres, promo |
| `TextareaField` | candidature |
| `FileUploadField` | candidature |
| `PrimaryButton` | login, candidature, creation compte |
| `SecondaryButton` | retours, annulations |
| `DataTable` | candidatures etudiant, etudiants pilote, candidatures pilote |
| `Card` | accueil, offres, entreprises, dashboard pilote |
| `Pagination` | listes offres, entreprises, etudiants si necessaire |
| `StatusBadge` | candidatures, etudiants, suivi |
| `Alert` | login, candidature, creation compte, pages protegees |
| `EmptyState` | listes sans contenu |

## 5. Conventions de composition

- une page formulaire critique combine toujours `Alert` + champs + `PrimaryButton` + `SecondaryButton`,
- une page liste combine toujours resume + contenu + etat vide + pagination si necessaire,
- une page detail combine toujours contexte retour + informations principales + action contextuelle,
- une page protegee combine toujours `HeaderRole` et une zone messages.

## 6. Contraintes responsive transversales

- un composant interactif doit rester utilisable sur petit ecran sans precision excessive,
- les boutons primaires doivent rester visibles au-dessus de la ligne de flottaison raisonnable,
- les formulaires ne doivent pas casser la lecture verticale,
- les tableaux doivent avoir une strategie mobile explicite,
- les cartes doivent conserver une hierarchie stable entre titre, meta, action.

## 7. Contraintes accessibilite transversales

- tous les champs ont un label explicite,
- tous les boutons ont un texte comprehensible hors contexte,
- l'etat focus est visible partout,
- les messages d'erreur sont relies aux champs concernes,
- les statuts ne reposent jamais uniquement sur la couleur,
- la navigation clavier doit permettre d'atteindre toutes les actions importantes.

## 8. Cas interdits globaux

- creer un composant specifique a une page pour un besoin deja couvert par un composant commun,
- multiplier les variantes de boutons sans difference fonctionnelle,
- utiliser une modale pour un flux principal long,
- cacher une erreur critique sans feedback utilisateur,
- exposer des actions interdites par role via un composant generique mal configure.

## 9. Definition of Done du Lot 5

Le `Lot 5` est considere comme exploitable si :

- chaque composant principal du MVP est nomme,
- chaque composant principal a variantes et etats documentes,
- les regles de placement sont explicites,
- les contraintes responsive et accessibilite sont notees,
- un developpeur peut choisir le bon composant sans hesitation.
