# Plan de phase P7

Ce document fixe un plan d'execution court et concret pour `P7. Modules avances`.

Il part de l'etat reel du repo :

- la candidature de base existe deja,
- la liste `Mes candidatures` existe deja,
- le suivi pilote de base existe deja,
- la wish-list, les statistiques et le profil etudiant ne sont pas encore implementes.

## 1. Objectif de la phase

Clore les usages metier avances encore manquants afin d'obtenir une application demonstrable au-dela du simple socle coeur :

- candidature complete,
- suivi pilote complet,
- wish-list complete,
- statistiques minimales exploitables,
- profil etudiant minimal si retenu dans le perimetre final.

## 2. Ordre d'execution recommande

### P7.1 Candidatures - finition metier

Finaliser le module deja entame :

- telechargement securise du CV pour l'etudiant,
- telechargement securise du CV pour le pilote autorise,
- affichage detaille d'une candidature si necessaire,
- verification stricte des acces sur les fichiers et les candidatures.

Sortie attendue :
la candidature est complete de bout en bout, y compris l'acces aux pieces deposees.

### P7.2 Wish-list

Construire le module complet :

- table dediee,
- ajout depuis une offre,
- liste de wish-list etudiant,
- retrait,
- blocage des doublons,
- guards serveur.

Sortie attendue :
un etudiant peut enregistrer, consulter et retirer ses offres favorites.

### P7.3 Suivi pilote - extension

Completer la supervision pilote :

- acces aux CV des etudiants de la promo,
- detail des candidatures si retenu,
- verifications hors promotion sur toutes les routes derivees,
- messages d'erreur clairs sur les acces refuses.

Sortie attendue :
le pilote peut suivre sa promotion sans fuite de donnees hors perimetre.

### P7.4 Statistiques

Implementer un premier lot de statistiques conforme a la matrice :

- nombre d'offres publiees,
- nombre moyen de candidatures par offre,
- indicateurs simples exploitables en soutenance,
- exposition sur une route dediee accessible selon les droits retenus.

Sortie attendue :
un module de stats minimal, lisible et defendable.

### P7.5 Profil etudiant

Arbitrer puis implementer le profil minimal si la phase le conserve :

- vue profil,
- edition des informations personnelles non sensibles,
- validation serveur,
- non-regression sur l'authentification.

Si le profil est reporte :
acter explicitement son report vers `P8` ou hors MVP et ne pas le laisser dans une zone floue.

Sortie attendue :
profil minimal implemente ou report formalise.

### P7.6 Verification de phase

Clore `P7` avec une verification complete :

- parcours candidature complet,
- parcours wish-list complet,
- suivi pilote complet,
- stats accessibles selon le role,
- verifications `403`, `404`, doublons et acces hors promo.

Sortie attendue :
`P7` validable sans dependre d'interpretations implicites.

## 3. Definition of Done

`P7` pourra etre consideree comme terminee si :

- tous les modules ci-dessus sont soit implementes, soit explicitement reportes,
- les permissions restent alignees avec la matrice,
- les acces fichiers et donnees sensibles sont controles cote serveur,
- un smoke test ou lot de verifications reproductibles couvre les nouveaux parcours.

## 4. Prochaine action

Commencer par `P7.1 Candidatures - finition metier`.
