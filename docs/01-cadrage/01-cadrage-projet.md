# Cadrage projet

## 1. Nom du projet

`InternHub` est un nom de travail pour la plateforme web de gestion et de recherche de stages.

## 2. Contexte

Les etudiants recherchent actuellement leurs stages en mobilisant leurs reseaux personnels et professionnels, puis en postulant a des offres dispersees sur plusieurs canaux.

Le projet vise a centraliser cette demarche au sein d'un site web unique permettant :

- de consulter des offres de stage,
- de retrouver des entreprises ayant deja accueilli des stagiaires,
- de suivre des candidatures,
- de gerer des comptes selon plusieurs roles.

## 3. Probleme a resoudre

La recherche de stage manque aujourd'hui de centralisation, de lisibilite et de capitalisation des retours d'experience. Les nouveaux etudiants disposent de peu d'informations consolidees sur les entreprises et les opportunites pertinentes pour leur profil.

## 4. Objectif principal

Concevoir une application web responsive qui facilite la recherche de stage et la gestion des informations associees pour les etudiants, les pilotes de promotion et les administrateurs.

## 5. Objectifs secondaires

- Centraliser les offres de stage.
- Structurer les donnees entreprises et offres.
- Permettre une recherche par criteres et par competences.
- Gerer les candidatures et les wish-lists.
- Encadrer les acces selon les roles.
- Fournir une base defendable en soutenance sur les choix fonctionnels et techniques.

## 6. Parties prenantes

- Client / jury : CESI.
- Equipe projet : groupe de 4 etudiants.
- Utilisateurs finaux :
  - administrateur,
  - pilote de promotion,
  - etudiant,
  - visiteur anonyme.

## 7. Livrable attendu

Le livrable final comprend :

- une application web fonctionnelle,
- une demonstration technique en soutenance,
- une presentation courte orientee besoin, solution, architecture et decisions,
- une capacite a justifier les choix retenus.

## 8. Contraintes imposées

- Architecture MVC obligatoire.
- Backend en PHP, avec POO obligatoire.
- Frontend en HTML5, CSS3, JavaScript.
- Serveur Apache.
- Base de donnees SQL avec acces via `PHP PDO`.
- Aucun framework type React, Vue, Angular, Laravel ou Symfony.
- Utilisation obligatoire d'un moteur de template cote backend.
- Responsive design obligatoire.
- Tests unitaires requis sur au moins un controleur via PHPUnit.
- Bonnes pratiques de securite, SEO, legalite et validation des formulaires.

## 9. Perimetre fonctionnel

Le projet couvre les domaines suivants :

- authentification et gestion des acces,
- gestion des entreprises,
- gestion des offres,
- gestion des pilotes,
- gestion des etudiants,
- gestion des candidatures,
- gestion des wish-lists,
- pagination,
- mentions legales.

## 10. Criteres de succes

Le projet sera considere comme solide si :

- les parcours principaux sont demontrables de bout en bout,
- les droits d'acces sont respectes,
- la structure MVC est claire,
- la base de donnees couvre les entites principales et leurs relations,
- l'application est responsive,
- les choix sont documentes et justifiables.

## 11. Risques initiaux identifies

- Cahier des charges comportant plusieurs zones d'ombre.
- Incoherences entre certaines attentes fonctionnelles et la matrice des permissions.
- Volume fonctionnel important pour un groupe de 4.
- Risque de demarrer le code avant d'avoir valide les conventions et le perimetre MVP.

## 12. Ligne de conduite recommandee

- Stabiliser rapidement le MVP.
- Documenter les hypotheses avant implementation.
- Prioriser les parcours critiques plutot que la couverture exhaustive immediate.
- Mettre en place une organisation Scrum simple et maintenable.
