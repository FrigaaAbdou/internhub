# P9.5 Repartition de la soutenance

Ce document fixe une repartition de parole claire pour la soutenance `InternHub`.

Le repo ne contient pas de liste officielle des membres ni de nommage d equipe exploitable. La repartition est donc formulee par `Intervenant 1`, `Intervenant 2`, `Intervenant 3`, `Intervenant 4`.

L objectif est de fournir une structure directement assignable, sans zone morte ni recouvrement inutile.

## 1. Principes de repartition

La soutenance doit respecter ces regles :

- une personne ouvre et cadence la presentation,
- une personne porte le besoin et le produit,
- une personne porte l architecture et les choix techniques,
- une personne mene la demo,
- la qualite et la verification doivent etre traitees explicitement,
- la conclusion doit etre courte et nette.

## 2. Repartition recommandee pour une equipe de 4

### Intervenant 1. Ouverture et cadrage produit

Responsabilites :

- ouvrir la presentation,
- presenter le besoin,
- rappeler le contexte et les roles,
- annoncer le plan de passage.

Bloc conseille :

- `1 min 30`

Ce qu il couvre :

- probleme adresse,
- objectif de la plateforme,
- roles `anonyme`, `etudiant`, `pilote`, `administrateur`,
- annonce du fil directeur de la demo.

Transition type :

`Je laisse maintenant la main pour expliquer comment nous avons structure techniquement cette plateforme et pourquoi nous avons retenu cette architecture.`

### Intervenant 2. Architecture et choix techniques

Responsabilites :

- presenter `PHP MVC + PDO`,
- expliquer le routeur, les controleurs, les vues et les repositories,
- justifier les choix de securite de base,
- rappeler la logique de permissions.

Bloc conseille :

- `2 min`

Ce qu il couvre :

- architecture,
- separation des responsabilites,
- `PDO`,
- middlewares,
- `CSRF`,
- session serveur,
- alignement sur la matrice de permissions.

Transition type :

`Une fois ce socle en place, nous pouvons montrer comment il se traduit dans les parcours utilisateurs reellement demonstrables.`

### Intervenant 3. Demonstration fonctionnelle

Responsabilites :

- mener la demonstration en direct,
- suivre strictement le script `P9.1`,
- annoncer le role courant a chaque bascule,
- ne pas improviser hors du parcours prepare.

Bloc conseille :

- `4 a 5 min`

Ce qu il couvre :

- parcours public,
- parcours etudiant,
- parcours pilote,
- parcours administrateur.

Regle :

- cette personne parle moins de theorie et plus d usage concret.

Transition type :

`La demonstration montre les parcours metier. Je termine en montrant comment nous avons securise et verifie l application pour la rendre defendable en soutenance.`

### Intervenant 4. Qualite, verification et conclusion

Responsabilites :

- presenter les tests et la stabilisation,
- rappeler le reset de demo,
- traiter les limites connues avec honnetete,
- conclure la presentation.

Bloc conseille :

- `2 min`

Ce qu il couvre :

- `PHPUnit`,
- smoke tests `P6`, `P7`, `P8`,
- stabilisation,
- jeu de donnees de demo,
- limites actuelles,
- conclusion finale.

## 3. Variante pour une equipe de 3

Si l equipe est composee de `3` personnes :

- `Intervenant 1` garde l ouverture et le cadrage produit,
- `Intervenant 2` absorbe architecture + qualite,
- `Intervenant 3` garde toute la demonstration.

Repartition conseillee :

1. produit et contexte
2. architecture, securite, verification
3. demonstration et conclusion courte

## 4. Variante pour une equipe de 2

Si l equipe est composee de `2` personnes :

- `Intervenant 1` : besoin, architecture, securite
- `Intervenant 2` : demonstration, qualite, conclusion

Regle stricte :

- ne pas multiplier les transitions,
- garder une structure tres lisible,
- assumer une soutenance plus compacte.

## 5. Points a ne pas laisser sans porteur

Quel que soit le nombre de personnes, il faut qu une personne soit clairement responsable de :

- l introduction,
- l architecture,
- la demonstration,
- les tests et la verification,
- la conclusion.

## 6. Repartition minutee recommandee

Pour une soutenance courte de `10 minutes` :

1. `1 min 30` ouverture et besoin
2. `2 min` architecture et choix techniques
3. `4 min 30` demonstration
4. `1 min 30` qualite et verification
5. `30 sec` conclusion

## 7. Checklist avant affectation des noms

Avant de remplacer les slots par des noms, verifier :

1. que chaque intervenant maitrise vraiment son bloc,
2. que les transitions sont memorisees,
3. que personne ne presente une partie qu il ne comprend pas,
4. que la personne qui fait la demo est la plus a l aise en execution live,
5. que la conclusion est portee par quelqu un de synthétique.

## 8. Resultat du lot

`P9.5` est considere comme valide si :

- une repartition exploitable existe,
- chaque bloc a un proprietaire,
- les transitions sont explicites,
- une variante existe pour une equipe reduite.

## 9. Prochaine action

Passer a `P9.6 Repetition complete`.
