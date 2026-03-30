# Plan de phase P9

Ce document fixe un plan court et concret pour `P9. Livraison et soutenance`.

Il part de l etat reel du repo apres `P8` :

- `P5` a `P8` sont implementes et verifies,
- un protocole de verification complet existe deja,
- l application est demonstrable localement,
- le risque principal n est plus le code brut mais la qualite de la demonstration,
- la soutenance doit maintenant etre preparee comme un livrable, pas comme une simple visite de l application.

## 1. Objectif de la phase

Transformer l application en version de demo defendable face au jury :

- parcours de demonstration choisis,
- donnees et comptes de demo figes,
- argumentaire technique pret,
- documentation finale propre,
- repetition de soutenance rejouable.

## 2. Ordre d execution recommande

### P9.1 Script de demo

Definir un script de demonstration court, credible et maitrise.

Le script doit repondre a trois questions :

- que montre-t-on,
- dans quel ordre,
- pourquoi ce parcours prouve que le projet est reussi.

Le script cible doit couvrir :

- visiteur,
- etudiant,
- pilote,
- administrateur,
- un ou deux cas limites bien choisis.

Sortie attendue :
un support de demo minute par minute avec ordre des ecrans et messages clefs.

### P9.2 Jeu de donnees et comptes de demo

Figer le contexte de demo pour eviter toute improvisation fragile.

A preparer :

- comptes de demonstration definitifs,
- entreprises et offres coherentes,
- candidatures visibles,
- statistiques non vides,
- un etat initial stable rejouable avant chaque repetition.

Sortie attendue :
une base de demo propre avec un protocole simple de reinitialisation.

### P9.3 Documentation finale de livraison

Produire le lot final de documents utiles pour la soutenance et la remise.

A consolider :

- presentation du projet,
- architecture retenue,
- permissions appliquees,
- choix techniques,
- limites connues,
- protocole d installation et de lancement,
- protocole de verification.

Sortie attendue :
un dossier final lisible par une personne externe au projet.

### P9.4 Argumentaire technique et fonctionnel

Preparer les explications que le jury va attendre.

Themes a verrouiller :

- pourquoi `PHP MVC + PDO`,
- comment les droits sont appliques,
- comment les candidatures et uploads sont proteges,
- comment les tests et smoke tests securisent le projet,
- quels arbitrages ont ete faits sur le MVP,
- quelles limites restent hors perimetre.

Sortie attendue :
une liste de reponses courtes, precises et coherentes aux questions previsibles.

### P9.5 Repartition de la soutenance

Organiser la parole de l equipe pour eviter les zones mortes et les doublons.

A definir :

- qui ouvre la presentation,
- qui presente le besoin,
- qui presente l architecture,
- qui mene la demo,
- qui traite les tests et la qualite,
- qui conclut.

Sortie attendue :
une repartition claire avec transitions explicites.

### P9.6 Repetition complete

Jouer une repetition complete comme si la soutenance etait reelle.

La repetition doit inclure :

- remise a zero du contexte de demo,
- lancement de l application,
- execution du script de demo,
- explications techniques,
- questions difficiles simulees,
- correction immediate des points faibles detectes.

Sortie attendue :
une version finale de soutenance plus stable, plus courte et plus defendable.

## 3. Definition of Done

`P9` pourra etre consideree comme terminee si :

- un script de demo officiel existe,
- les comptes et donnees de demo sont figes,
- la documentation de lancement et de verification est propre,
- les choix techniques et arbitrages sont expliques simplement,
- la repartition de parole est decidee,
- une repetition complete a ete faite et corrigee.

## 4. Prochaine action

Commencer par `P9.1 Script de demo`.
