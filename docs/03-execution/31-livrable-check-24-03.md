# Livrable check du 24/03

Ce document indique comment constituer proprement le premier livrable de verification demande au `24/03`.

Le cahier de remise demande :

- une premiere version du `MCD`,
- le planning previsionnel,
- tous les diagrammes `UML` finalises.

L'objectif de ce document est donc de dire :

1. quoi prendre dans le depot,
2. quoi rendre,
3. dans quel ordre presenter les pieces,
4. et sous quelle forme les remettre.

## 1. Ce qu'il faut rendre

Le livrable peut etre constitue de `3 blocs`.

## Bloc 1 - Premiere version du MCD

Document a utiliser :

- [09-modele-conceptuel-donnees.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/09-modele-conceptuel-donnees.md)

Parties a conserver en priorite :

- la legende des cardinalites,
- le resume du modele,
- les associations principales,
- le schema Merise simplifie.

Conseil :

- pour un livrable de verification, ce document suffit comme `premiere version du MCD`,
- il n'est pas necessaire d'ajouter le `MLD` si le livrable ne le demande pas explicitement.

## Bloc 2 - Planning previsionnel

Document a utiliser :

- [07-diagrammes-pert-gantt.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/07-diagrammes-pert-gantt.md)

Parties a conserver en priorite :

- le tableau des lots de travail,
- le diagramme `PERT`,
- le diagramme de `Gantt`,
- la repartition developpeur recommandee.

Ce document est le plus adapte pour representer le planning previsionnel, car il montre :

- les dependances,
- l'ordre logique des travaux,
- la planification dans le temps,
- et la repartition d'equipe.

## Bloc 3 - Diagrammes UML finalises

Documents / sources a utiliser :

- [08-analyse-uml.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/08-analyse-uml.md)
- les fichiers sources dans [docs/05-sources/uml](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml)

Fichiers UML identifies :

- [Page Map - Plateforme Stages (Site Map).png](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml/Page%20Map%20-%20Plateforme%20Stages%20%28Site%20Map%29.png)
- [Stage platform - User flow (Etudiant - Recherche -> Postuler).png](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml/Stage%20platform%20-%20User%20flow%20%28Etudiant%20-%20Recherche%20-%3E%20Postuler%29.png)
- [User Journey - Étudiant - Rechercher -> Postuler (CV+LM).png](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml/User%20Journey%20-%20%C3%89tudiant%20-%20Rechercher%20-%3E%20Postuler%20%28CV%2BLM%29.png)
- [title User Journey .png](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml/title%20User%20Journey%20.png)
- [Sequence - Login Student (Auth).png](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml/Sequence%20-%20Login%20Student%20%28Auth%29.png)
- [Sequence - Recherche Offres.png](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml/Sequence%20-%20Recherche%20Offres.png)
- [Sequence - Wish-list (Ajouter).png](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml/Sequence%20-%20Wish-list%20%28Ajouter%29.png)
- [Sequence - Postuler a une offre (CV+LM).png](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml/Sequence%20-%20Postuler%20a%20une%20offre%20%28CV%2BLM%29.png)
- [XPFDJjj04CVl-nJJd41LW7n3XIAYb7v884Ma-CHbiIV9blLkkZkh2bLzWBv5htuElrXj9xjsObKSa7wCV_EVpCIviSGDkLIoTxJ15E5PEbmR_ieahWX8Wn7h3K4Y3COaj6BsHQWjDpo5BOzV-1gNz2eHoiTShIKoncFI1ZgHi8BGcGvm2v6lvd_89O8hgigtlhmGKXDMjOMlpP9KgAeqOopaG-Uh8ZJgYtlkm2y6u2p6t1Rr.png](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml/XPFDJjj04CVl-nJJd41LW7n3XIAYb7v884Ma-CHbiIV9blLkkZkh2bLzWBv5htuElrXj9xjsObKSa7wCV_EVpCIviSGDkLIoTxJ15E5PEbmR_ieahWX8Wn7h3K4Y3COaj6BsHQWjDpo5BOzV-1gNz2eHoiTShIKoncFI1ZgHi8BGcGvm2v6lvd_89O8hgigtlhmGKXDMjOMlpP9KgAeqOopaG-Uh8ZJgYtlkm2y6u2p6t1Rr.png)

Le document [08-analyse-uml.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/08-analyse-uml.md) peut servir de page de synthese ou d'explication des UML si vous voulez ajouter un texte d'accompagnement.

## 2. Ce qu'il faut concretement envoyer

Le plus propre est de remettre :

1. un dossier `Livrable_Check_24_03`
2. contenant `3` sous-parties ou `3` PDF

Structure recommandee :

```text
Livrable_Check_24_03/
├── 01-MCD.pdf
├── 02-Planning-previsionnel.pdf
├── 03-UML/
│   ├── 01-Site-map.png
│   ├── 02-User-flow-etudiant.png
│   ├── 03-User-journey-etudiant.png
│   ├── 04-User-journey-pilote.png
│   ├── 05-Sequence-login.png
│   ├── 06-Sequence-recherche-offres.png
│   ├── 07-Sequence-wishlist.png
│   ├── 08-Sequence-postuler.png
│   └── 09-Use-case-global.png
└── 00-README-livrable.pdf
```

## 3. Option minimale si vous devez rendre tres vite

Si vous devez rendre le livrable rapidement, prenez uniquement :

- [09-modele-conceptuel-donnees.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/09-modele-conceptuel-donnees.md) -> export en PDF
- [07-diagrammes-pert-gantt.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/07-diagrammes-pert-gantt.md) -> export en PDF
- tous les `.png` du dossier [docs/05-sources/uml](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml)

Cela couvre deja exactement les trois exigences du livrable.

## 4. README tres court a joindre

Vous pouvez joindre un mini fichier d'accompagnement avec ce texte :

`Ce livrable de verification comprend une premiere version du modele conceptuel de donnees, le planning previsionnel de projet sous forme de diagrammes PERT et Gantt, ainsi que l'ensemble des diagrammes UML finalises utilises pour structurer l'application InternHub.`

## 5. Ce qu'il ne faut pas melanger inutilement

Pour ce livrable, il vaut mieux ne pas ajouter :

- la totalite du code source,
- les documents de soutenance,
- les tests,
- le MLD si non demande,
- les documents UX detailes si non demandes.

Le livrable du `24/03` doit rester centré sur :

- la conception de donnees,
- la planification,
- les UML.

## 6. Recommandation finale

Si tu dois le faire proprement maintenant :

1. exporter [09-modele-conceptuel-donnees.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/09-modele-conceptuel-donnees.md) en `PDF`,
2. exporter [07-diagrammes-pert-gantt.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/07-diagrammes-pert-gantt.md) en `PDF`,
3. prendre tous les diagrammes du dossier [docs/05-sources/uml](/Users/abdoufrigaa/Projects/internhub/docs/05-sources/uml),
4. les ranger dans un dossier propre,
5. ajouter un mini `README` d'une phrase.

En pratique, ce sont deja les bonnes ressources. Le vrai travail restant est surtout de les assembler proprement pour l'envoi.
