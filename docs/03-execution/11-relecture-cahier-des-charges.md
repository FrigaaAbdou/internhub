# Relecture du cahier des charges

Ce document formalise la premiere etape du plan d'execution : `P1.1 - Relire collectivement le cahier des charges`.

Il sert a verifier que l'equipe partage la meme lecture du besoin avant de figer le MVP, les roles et les conventions d'implementation.

## 1. Base de lecture retenue

La relecture ci-dessous est reconstruite a partir des sources presentes dans le depot :

- `01-cadrage-projet.md`
- `03-referentiel-fonctionnel.md`
- `04-roles-et-permissions.md`
- `05-zones-a-clarifier.md`
- `08-analyse-uml.md`
- `Matrice_permissions_2025_V2_1.json`

Hypothese de travail :
le cahier des charges initial n'est pas stocke tel quel dans le depot, donc cette relecture consolide la lecture deja derivee dans le dossier documentaire.

Regle de priorite :
pour tout ce qui concerne les droits d'acces par role, la source de verite est la `Matrice_permissions_2025_V2_1.json`.

## 2. But produit compris

`InternHub` doit etre une plateforme web responsive de recherche et de gestion de stages.

Le produit doit permettre de :

- consulter des offres de stage,
- consulter des entreprises,
- centraliser les candidatures,
- suivre les interactions etudiantes avec les offres,
- gerer des acces differencies selon les roles.

## 3. Utilisateurs identifies

Les roles compris a ce stade sont :

- `Administrateur`
- `Pilote`
- `Etudiant`
- `Anonyme`

Lecture partagee recommandee :

- `Anonyme` consulte l'information publique,
- `Etudiant` recherche, postule et suit ses candidatures,
- `Pilote` suit les etudiants de sa promotion,
- `Administrateur` gere les comptes, les offres et les entreprises.

## 4. Contraintes non negociables

Les contraintes qui ressortent comme obligatoires sont :

- architecture `MVC`,
- backend `PHP` en POO,
- frontend `HTML5`, `CSS3`, `JavaScript`,
- serveur `Apache`,
- base de donnees `SQL` avec acces via `PHP PDO`,
- aucun framework applicatif type `React`, `Vue`, `Angular`, `Laravel`, `Symfony`,
- moteur de template cote backend,
- responsive design,
- au moins un test unitaire de controleur avec `PHPUnit`,
- validations de formulaires cote front et cote back,
- respect des bases de securite, SEO et mentions legales.

## 5. Parcours coeur compris

Les parcours qui apparaissent comme centraux sont :

- se connecter et se deconnecter,
- rechercher et consulter des offres,
- rechercher et consulter des entreprises,
- consulter ou gerer des comptes selon le role,
- postuler a une offre avec `CV` et `LM`,
- consulter ses candidatures cote etudiant,
- consulter les candidatures de sa promotion cote pilote,
- gerer une wish-list cote etudiant.

## 6. Regles metier deja visibles

Les regles suivantes sont deja suffisamment explicites pour etre retenues comme base de discussion :

- un etudiant ne cree pas son propre compte depuis l'interface,
- une candidature doit etre unique par couple `etudiant/offre`,
- la wish-list ne doit pas contenir de doublons,
- certaines routes doivent etre strictement reservees au role `ETUDIANT`,
- le pilote ne doit voir que les donnees de sa promotion,
- les formulaires sensibles doivent etre proteges par `CSRF`,
- les fichiers de candidature ne doivent pas etre stockes directement en base.

## 7. Perimetre MVP suggere par la relecture

Si l'equipe veut rester alignee avec la charge projet, le MVP doit se concentrer sur :

- authentification,
- recherche et consultation des offres,
- recherche et consultation des entreprises,
- gestion minimale des comptes,
- candidature et suivi etudiant,
- controles d'acces par role,
- socle de securite minimum : session, `CSRF`, validation.

## 8. Points qui bloquent une implementation propre

Cette relecture confirme qu'il reste des arbitrages importants :

- la route `/register` existe dans les UML mais contredit la creation admin des comptes etudiants,
- la visibilite exacte des coordonnees entreprise n'est pas tranchee,
- la convention de routes melange francais et anglais,
- la convention `Controller / Service / Repository` n'est pas encore figee partout,
- la politique de suppression logique ou physique doit etre decidee.

## 9. Decisions recommandees a l'issue de cette etape

La relecture collective devrait aboutir aux validations suivantes :

- confirmer les 4 roles officiels,
- confirmer le perimetre MVP,
- confirmer que les comptes etudiants sont crees par `Admin` ou `Pilote`,
- confirmer les conventions de nommage des routes,
- confirmer les regles de visibilite des donnees sensibles,
- confirmer la suppression logique pour les entites metier principales.

## 10. Sortie attendue pour cloturer P1.1

L'etape peut etre consideree comme exploitable si l'equipe obtient :

- une lecture partagee du besoin,
- une liste d'invariants techniques imposes,
- une liste courte des parcours coeur,
- une liste d'arbitrages a traiter en reunion,
- une base commune pour lancer `P1.2` et `P1.3`.

## 11. Statut propose

- `P1.1` : documente
- `Validation equipe` : a faire
- `Pret pour suite` : oui, sous reserve d'arbitrer les points du chapitre 8
