# Plan d'implementation de P4 - UX et interfaces

Ce document decrit comment executer la phase `P4. UX et interfaces` de maniere defendable et exploitable en production.

Il ne s'agit pas seulement de produire des maquettes. L'objectif est de preparer un systeme d'interfaces suffisamment precis pour reduire les ambiguities avant implementation et limiter les regressions visuelles, fonctionnelles et d'accessibilite.

## 1. Objectif de la phase

Concevoir les ecrans, composants, etats et regles d'usage de l'interface afin de permettre une implementation frontend/backend fiable, cohérente et proche de la production.

## 2. Definition de "production-ready" pour P4

La phase `P4` ne sera consideree comme suffisamment preparee que si :

- chaque ecran prioritaire existe au moins en wireframe haute fidelite fonctionnelle,
- chaque parcours critique est decrit de bout en bout,
- chaque role dispose d'une navigation claire et conforme a la matrice de permissions,
- chaque composant commun a une specification d'usage,
- chaque formulaire critique couvre ses etats nominaux et d'erreur,
- le responsive mobile first est defini avec regles explicites,
- les exigences d'accessibilite de base sont integrees des la conception,
- les artefacts sont assez precis pour etre implementes sans deviner le comportement.

## 3. Preconditions obligatoires

Avant de lancer `P4`, il faut s'appuyer sur :

- [12-validation-roles-utilisateurs.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/12-validation-roles-utilisateurs.md)
- [13-validation-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/13-validation-mvp.md)
- [04-roles-et-permissions.md](/Users/abdoufrigaa/Projects/internhub/docs/01-cadrage/04-roles-et-permissions.md)
- [08-analyse-uml.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/08-analyse-uml.md)

Point de vigilance :
si les routes officielles ou la matrice changent, les ecrans doivent etre mis a jour avant tout passage en implementation.

## 4. Ordre d'execution recommande

### Lot 1 - Inventaire UX officiel

Objectif :
transformer les routes, permissions et parcours en inventaire d'ecrans fiable.

Travail a produire :

- lister les pages publiques,
- lister les pages etudiant,
- lister les pages pilote,
- lister les pages admin,
- marquer pour chaque page : role, route, but, donnees affichees, actions disponibles, dependances.

Livrable :

- un catalogue des vues officiel.

Critere de sortie :

- aucune route prioritaire n'est orpheline,
- aucune page n'autorise une action interdite par la matrice.

### Lot 2 - Architecture de navigation

Objectif :
definir une navigation coherent par role, sans melanger les contextes.

Travail a produire :

- structure de navigation publique,
- structure de navigation etudiant,
- structure de navigation pilote,
- structure de navigation admin,
- logique de redirection apres login selon le role,
- logique de redirection en cas d'acces refuse,
- logique de retour entre liste, detail et action.

Livrable :

- schema de navigation par role,
- regles de redirection et de garde UX.

Critere de sortie :

- chaque role sait toujours ou il se trouve,
- les pages partagees et les pages protegees sont clairement distinguees.

### Lot 3 - Priorisation des ecrans a concevoir

Objectif :
eviter de maqueter tout le produit avant d'avoir securise les parcours coeur.

Ordre de priorite recommande :

1. login
2. liste des offres
3. detail offre
4. candidature
5. liste des candidatures etudiant
6. liste des entreprises
7. detail entreprise
8. dashboard pilote
9. liste des etudiants pilote
10. candidatures de la promotion
11. dashboard admin
12. gestion minimale des comptes etudiants
13. pages d'erreur `403`, `404`, `500`

Livrable :

- liste des wireframes prioritaires avec ordre de production.

Critere de sortie :

- les ecrans couvrent les parcours du MVP avant les fonctionnalites secondaires.

### Lot 4 - Wireframes structurels

Objectif :
poser la structure de chaque ecran avant toute direction visuelle detaillee.

Travail a produire pour chaque ecran prioritaire :

- header,
- navigation,
- titre de page,
- zone d'action principale,
- contenu principal,
- bloc de filtres si present,
- tableau ou cartes si present,
- pagination si presente,
- messages systeme,
- footer.

Livrable :

- wireframes basse ou moyenne fidelite de tous les ecrans prioritaires.

Critere de sortie :

- toutes les zones fonctionnelles sont visibles,
- aucun ecran n'oublie les etats critiques.

### Lot 5 - Systeme de composants

Objectif :
definir un langage d'interface reutilisable avant integration.

Composants a specifier en premier :

- header public
- header authentifie
- navigation laterale dashboard
- footer
- champ texte
- champ email
- champ mot de passe
- select
- textarea
- upload de fichier
- bouton primaire
- bouton secondaire
- bouton de danger
- tableau
- carte
- badge de statut
- pagination
- alerte succes
- alerte erreur
- alerte information
- etat vide
- modale de confirmation si retenue

Pour chaque composant, documenter :

- role fonctionnel,
- variantes,
- etats,
- regles de placement,
- contraintes responsive,
- contraintes accessibilite,
- cas interdits.

Livrable :

- inventaire des composants UI communs.

Critere de sortie :

- un developpeur peut reutiliser les composants sans redecider leur comportement.

### Lot 6 - Etats et messages

Objectif :
eviter les zones grises au moment de coder.

Etats a documenter pour chaque page critique :

- chargement,
- vide,
- succes,
- erreur metier,
- erreur technique,
- acces refuse,
- donnee introuvable,
- permission insuffisante.

Etats a documenter pour chaque formulaire critique :

- initial,
- champ invalide,
- formulaire invalide,
- soumission en cours,
- succes de soumission,
- erreur de soumission,
- doublon fonctionnel,
- token `CSRF` invalide,
- fichier refuse.

Livrable :

- matrice des etats d'interface et des messages.

Critere de sortie :

- tous les comportements de feedback sont explicitement definis.

### Lot 7 - Responsive mobile first

Objectif :
garantir une implementation robuste sur mobile et desktop.

Travail a produire :

- definir les breakpoints projet,
- definir les largeurs max de contenu,
- definir le comportement des tableaux sur mobile,
- definir le comportement des filtres sur mobile,
- definir le comportement des formulaires longs sur mobile,
- definir les espacements et tailles minimales de zones cliquables,
- definir l'ordre de lecture mobile.

Livrable :

- spec responsive par famille d'ecrans et de composants.

Critere de sortie :

- les parcours critiques sont utilisables sur petit ecran sans degradation majeure.

### Lot 8 - Accessibilite integree

Objectif :
traiter l'accessibilite en amont plutot qu'en correction tardive.

Exigences minimales a integrer :

- hierarchie claire des titres,
- labels explicites pour tous les champs,
- messages d'erreur relies aux champs,
- navigation clavier viable,
- contraste suffisant,
- ordre de focus coherent,
- textes de boutons non ambigus,
- alternatives textuelles pour icones utiles,
- etats visibles au focus et au survol,
- absence de couleur seule comme seul indicateur.

Livrable :

- checklist accessibilite de conception.

Critere de sortie :

- les wireframes et specs n'introduisent pas d'obstacles evidents avant implementation.

### Lot 9 - Prototype et validation des parcours

Objectif :
verifier les enchainements reels avant coding.

Parcours a prototyper en priorite :

- visiteur : accueil ou landing -> offres -> detail offre -> login
- etudiant : login -> dashboard -> offres -> detail offre -> postuler -> candidatures
- pilote : login -> dashboard pilote -> etudiants -> candidatures
- admin : login -> dashboard admin -> comptes etudiants

Livrable :

- prototype cliquable ou equivalent navigable,
- revue de parcours par role.

Critere de sortie :

- aucun parcours critique ne presente d'impasse UX.

### Lot 10 - Handoff vers implementation

Objectif :
faire de `P4` un vrai pont vers le dev et non une simple intention graphique.

Artefacts a remettre :

- catalogue des vues,
- schema de navigation,
- wireframes prioritaires,
- spec composants,
- matrice des etats,
- spec responsive,
- checklist accessibilite,
- liste des contenus de demo a simuler,
- liste des decisions ouvertes residuelles.

Critere de sortie :

- un developpeur peut implementer les vues sans reinventer la logique UX.

## 5. Documents a produire pendant P4

Je recommande de produire au minimum les documents suivants :

- `15-inventaire-vues.md`
- `16-navigation-et-parcours.md`
- `17-wireframes-prioritaires.md`
- `18-systeme-composants-ui.md`
- `19-matrice-etats-formulaires.md`
- `20-spec-responsive-accessibilite.md`

## 6. Standards de qualite a imposer

Pour que le travail soit suffisamment robuste pour la production :

- pas de maquette sans role ni route explicite,
- pas de composant sans etats documentes,
- pas de formulaire sans parcours d'erreur,
- pas de tableau sans comportement mobile,
- pas de page protegee sans scenario d'acces refuse,
- pas de navigation sans regle de redirection apres login,
- pas d'ecran "beau" mais non implementable dans l'architecture retenue.

## 7. Definition of Done de P4

La phase `P4` est terminee seulement si :

- les ecrans MVP sont tous couverts,
- les parcours critiques sont valides,
- les composants communs sont documentes,
- les etats d'erreur et d'acces sont definis,
- la conception est compatible avec les roles et permissions,
- le responsive mobile first est specifie,
- l'accessibilite de base est integree,
- les artefacts sont assez precis pour lancer l'implementation sans ambiguite majeure.

## 8. Sequence de travail recommandee

Sequence pragmatique :

1. finaliser l'inventaire des vues a partir des routes et du MVP,
2. verrouiller la navigation par role,
3. produire les wireframes des ecrans MVP,
4. definir le systeme de composants communs,
5. documenter les etats et erreurs,
6. definir le responsive et l'accessibilite,
7. prototyper les parcours critiques,
8. faire une revue croisee design/dev,
9. corriger les incoherences,
10. geler les artefacts de handoff.

## 9. Risques a controler

- deriver vers des maquettes non alignees avec les permissions,
- oublier les ecrans d'erreur et d'etat vide,
- produire des interfaces trop ambitieuses pour le temps disponible,
- concevoir des tableaux inutilisables sur mobile,
- repousser l'accessibilite trop tard,
- designer des parcours contredisant le MVP valide,
- laisser des zones floues sur les formulaires de candidature.

## 10. Recommandation concrete

Si l'objectif est vraiment un niveau production-ready, je ne commencerais pas par un design visuel detaille.

Je commencerais par :

1. inventaire des vues,
2. parcours par role,
3. wireframes fonctionnels,
4. etats et composants,
5. seulement ensuite une couche visuelle plus fine.

Sans cela, l'equipe risque de produire des maquettes jolies mais non implementables proprement.
