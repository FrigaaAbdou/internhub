# Diagrammes PERT et Gantt

Ce document propose une vision de planification centree sur les travaux des developpeurs.

Hypothese retenue :
Le terme `diagramme de perte` est interprete ici comme `diagramme PERT`, car c'est le format adapte pour montrer les dependances entre taches projet.

Date de depart proposee :
Le calendrier ci-dessous commence le `lundi 30 mars 2026`.

## 1. Objectif

Ces diagrammes servent a :

- visualiser l'ordre logique des travaux,
- identifier les dependances bloquantes,
- estimer un chemin critique,
- repartir les travaux entre developpeurs sans perdre la coherence technique.

## 2. Perimetre developpeur retenu

Les travaux pris en compte sont les lots techniques principaux :

- cadrage technique et conventions,
- maquettage et parcours publics,
- architecture MVC et routage,
- modelisation des donnees,
- developpement frontend statique,
- developpement backend metier,
- authentification et permissions,
- connexion base de donnees,
- candidatures et wish-list,
- tests, recette et preparation de demo.

## 3. Lots de travail

| Code | Lot developpeur | Duree | Description | Depend de |
| --- | --- | --- | --- | --- |
| A | Cadrage technique | 4 j | conventions Git, organisation, backlog technique, documentation de depart | aucun |
| B | UX et maquettes | 5 j | wireframes, parcours, ecrans principaux | A |
| C | Architecture MVC | 4 j | structure cible, routage, conventions controleurs/vues/models | A |
| D | MCD et schema SQL | 4 j | modelisation, schema relationnel, dictionnaire de donnees | A |
| E | Frontend public | 6 j | integration accueil, listes, details, responsive | B |
| F | Backend entreprises et offres | 6 j | routes metier, controleurs, logique coeur | C, D |
| G | Auth et permissions | 5 j | connexion, sessions, roles, restrictions d'acces | C, D |
| H | Integration base | 4 j | scripts SQL, cles etrangeres, branchement applicatif | D, F |
| I | Candidatures et wish-list | 6 j | postulation, suivi etudiant, vue pilote, wishlist | F, G, H |
| J | Tests et recette | 5 j | tests unitaires, verifications fonctionnelles, corrections | E, H, I |
| K | Preparation soutenance | 3 j | demo, argumentaire technique, justification des choix | J |

## 4. Diagramme PERT chiffre

Convention de lecture :

- nombre en haut a gauche : date au plus tot de l'evenement,
- nombre en haut a droite : date au plus tard de l'evenement,
- nombre en bas : numero de l'evenement,
- nombre entre parentheses sur la fleche : duree de la tache en jours ouvres.

```mermaid
flowchart LR
    N0["Evt 0 | tot 0 | tard 0 | Debut"]
    N1["Evt 1 | tot 4 | tard 4"]
    N2["Evt 2 | tot 9 | tard 18"]
    N3["Evt 3 | tot 8 | tard 8"]
    N4["Evt 4 | tot 8 | tard 8"]
    N5["Evt 5 | tot 15 | tard 24"]
    N6["Evt 6 | tot 14 | tard 14"]
    N7["Evt 7 | tot 13 | tard 18"]
    N8["Evt 8 | tot 18 | tard 18"]
    N9["Evt 9 | tot 24 | tard 24"]
    N10["Evt 10 | tot 29 | tard 29"]
    N11["Evt 11 | tot 32 | tard 32 | Fin"]
    N0 -->|"A (4j)"| N1
    N1 -->|"B (5j)"| N2
    N1 -->|"C (4j)"| N3
    N1 -->|"D (4j)"| N4
    N3 -.->|"L1 (0j)"| N4
    N2 -->|"E (6j)"| N5
    N4 -->|"F (6j)"| N6
    N4 -->|"G (5j)"| N7
    N6 -->|"H (4j)"| N8
    N7 -.->|"L2 (0j)"| N8
    N8 -->|"I (6j)"| N9
    N5 -.->|"L3 (0j)"| N9
    N9 -->|"J (5j)"| N10
    N10 -->|"K (3j)"| N11
```

## 5. Correspondance des evenements

| Evenement | Signification | Plus tot | Plus tard |
| --- | --- | --- | --- |
| 0 | Debut projet | 0 | 0 |
| 1 | Cadrage technique valide | 4 | 4 |
| 2 | UX et maquettes terminees | 9 | 18 |
| 3 | Architecture MVC terminee | 8 | 8 |
| 4 | Conception technique stabilisee | 8 | 8 |
| 5 | Frontend public termine | 15 | 24 |
| 6 | Backend coeur termine | 14 | 14 |
| 7 | Authentification et permissions terminees | 13 | 18 |
| 8 | Base integree et dependances techniques levees | 18 | 18 |
| 9 | Candidatures et wish-list terminees | 24 | 24 |
| 10 | Tests et recette termines | 29 | 29 |
| 11 | Fin de la preparation technique | 32 | 32 |

## 6. Lecture du PERT

Points importants :

- `A`, `C`, `D`, `F`, `H`, `I`, `J` et `K` sont critiques pour tenir la duree globale.
- les taches `B`, `E` et `G` disposent d'une marge, ce qui explique l'ecart entre les dates au plus tot et au plus tard de certains evenements.
- les liaisons `C'`, `G'` et `E'` sont des taches fictives de duree `0`. Elles servent uniquement a modeliser correctement les dependances.

Chemins critiques :

- `A -> C -> F -> H -> I -> J -> K`
- `A -> D -> F -> H -> I -> J -> K`

Duree totale estimee :

`32 jours ouvres`

## 7. Diagramme de Gantt

Le diagramme suivant presente une proposition de calendrier equipe simplifiee pour un rendu Mermaid plus propre. Les libelles sont volontairement tres courts et les details sont reportes dans le tableau de correspondance.

```mermaid
gantt
    title Gantt developpeur - InternHub
    dateFormat  YYYY-MM-DD
    axisFormat  %d/%m
    excludes    weekends

    section Cadrage
    D1 Cadrage                          :d1, 2026-03-30, 4d

    section Conception
    D2 UX                               :d2, 2026-04-03, 5d
    D3 MVC                              :d3, 2026-04-03, 4d
    D4 SQL                              :d4, 2026-04-03, 4d

    section Dev coeur
    D5 Front                            :d5, 2026-04-10, 6d
    D6 Backend                          :d6, 2026-04-09, 6d
    D7 Auth                             :d7, 2026-04-09, 5d
    D8 DB                               :d8, 2026-04-17, 4d

    section Fonctions avancees
    D9 Candidatures                     :d9, 2026-04-23, 6d

    section Stabilisation
    D10 Tests                           :d10, 2026-05-01, 5d
    D11 Soutenance                      :d11, 2026-05-08, 3d
```

Correspondance des codes du Gantt :

| Code | Signification |
| --- | --- |
| D1 | Cadrage technique |
| D2 | UX et maquettes |
| D3 | Architecture MVC |
| D4 | MCD et schema SQL |
| D5 | Frontend public |
| D6 | Backend entreprises et offres |
| D7 | Authentification et permissions |
| D8 | Integration base de donnees |
| D9 | Candidatures et wish-list |
| D10 | Tests et recette |
| D11 | Preparation soutenance |

Principes retenus :

- les weekends sont exclus pour lire le planning en jours ouvres,
- `D5`, `D6` et `D7` avancent en parallele pour representer le travail reel d'une equipe,
- `D8` commence apres la stabilisation du backend coeur,
- `D9` commence une fois la base et les droits suffisamment fiables,
- le chemin critique reste explique dans la partie PERT, pas dans le rendu couleur du Gantt.

## 8. Repartition developpeur recommandee

Cette repartition est une proposition de travail en parallele pour un groupe de 4.

| Membre | Perimetre principal | Travaux prioritaires |
| --- | --- | --- |
| Abdou | Structure applicative | D3, D6 |
| Mehdi | Frontend et integration | D2, D5 |
| Karim | Donnees et SQL | D4, D8 |
| Oussama | Securite et comptes | D7, D9 |

Travail collectif :

- D1 doit etre valide par toute l'equipe.
- D10 et D11 doivent etre prepares collectivement.

## 9. Points de vigilance

- Si `D4` prend du retard, le backend et la base seront bloques.
- Si `D7` est sous-estime, les restrictions de roles seront traitees trop tard.
- Si `D5` avance sans alignement avec `D3`, il y aura des reworks d'integration.
- Si `D10` commence trop tard, la soutenance reposera sur une version instable.

## 10. Usage recommande

Ce document peut servir :

- en reunion d'equipe pour valider l'ordre des travaux,
- en daily pour situer les dependances,
- en soutenance pour justifier la logique d'organisation,
- en backlog refinement pour convertir les lots en user stories et taches techniques.
