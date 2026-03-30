# Validation du MVP

Ce document formalise la troisieme etape du plan d'execution : `P1.3 - Valider le MVP`.

Il sert a figer un perimetre de livraison minimal, coherent et defendable pour `InternHub`, avant de poursuivre les arbitrages et le decoupage technique.

## 1. Regles de cadrage du MVP

Le MVP retenu doit respecter les principes suivants :

- couvrir un parcours demonstrable de bout en bout,
- respecter la `Matrice_permissions_2025_V2_1.json` pour les droits d'acces,
- rester realisable par l'equipe dans le temps imparti,
- privilegier les fonctionnalites coeur plutot que la couverture exhaustive,
- inclure les exigences techniques minimales imposees par le sujet.

Source de verite pour les permissions :
`docs/05-sources/permissions/Matrice_permissions_2025_V2_1.json`

## 2. Objectif produit du MVP

Le MVP doit permettre de demontrer que la plateforme :

- authentifie correctement ses utilisateurs,
- applique des restrictions d'acces selon les roles,
- permet de consulter les offres et les entreprises,
- permet a un etudiant de postuler et de suivre ses candidatures,
- permet a un pilote de suivre les candidatures des etudiants de sa promotion,
- repose sur un socle technique securise et presentable en soutenance.

## 3. Perimetre fonctionnel inclus dans le MVP

Les fonctionnalites suivantes sont retenues dans le MVP.

### 3.1 Acces et socle

- `SFx1` : authentification et gestion des acces
- `SFx27` : pagination

Justification :
sans authentification ni controle d'acces, la plateforme ne peut pas demontrer la separation des roles. Sans pagination, les vues listes restent inachevees.

### 3.2 Consultation coeur

- `SFx2` : rechercher et afficher une entreprise
- `SFx7` : rechercher et afficher une offre

Justification :
la consultation publique et authentifiee des offres et entreprises est le point d'entree naturel du produit.

### 3.3 Gestion minimale des comptes

- `SFx16` : rechercher et afficher un compte etudiant
- `SFx17` : creer un compte etudiant

Justification :
le sujet ne prevoit pas d'auto-inscription etudiante. Le MVP doit donc inclure au minimum un mecanisme de creation et de consultation des comptes etudiants par les roles autorises (`Administrateur` et `Pilote`).

### 3.4 Parcours etudiant

- `SFx20` : postuler a une offre
- `SFx21` : afficher la liste des offres pour lesquelles l'etudiant a postule

Justification :
ces deux fonctionnalites portent la valeur principale du produit cote etudiant et constituent le coeur metier le plus defendable en soutenance.

### 3.5 Parcours pilote

- `SFx22` : afficher la liste des offres auxquelles les eleves du pilote ont postule

Justification :
le role `Pilote` fait partie du sujet et de la matrice. Le MVP doit montrer une vraie difference de role, pas seulement un CRUD admin.

## 4. Exigences transversales incluses dans le MVP

Le MVP doit aussi inclure les exigences suivantes, meme si elles ne sont pas toutes porteuses d'un code `SFx` dans la matrice :

- validation des formulaires cote front et back,
- protection `CSRF` des formulaires sensibles,
- session serveur avec cookie securise,
- respect des permissions cote serveur,
- responsive sur les ecrans principaux,
- au moins un test unitaire de controleur,
- base `SQL` avec acces via `PHP PDO`,
- pages d'erreur minimales `403`, `404`, `500`.

## 5. Fonctionnalites explicitement differees hors MVP

Les fonctionnalites suivantes peuvent etre reportees sans casser la demonstration du coeur produit :

- `SFx3` a `SFx6` : creation, modification, evaluation et suppression d'entreprise
- `SFx8` a `SFx10` : creation, modification et suppression d'offre
- `SFx11` : statistiques des offres
- `SFx12` a `SFx15` : gestion des comptes pilotes
- `SFx18` et `SFx19` : modification et suppression de compte etudiant
- `SFx23` a `SFx25` : wish-list
- `SFx28` : mentions legales

Justification :
ces fonctionnalites enrichissent le produit, mais ne sont pas indispensables pour demontrer un parcours central complet `consultation -> authentification -> candidature -> suivi`.

## 6. Correspondance backlog recommandee

Le MVP valide doit couvrir au minimum les items suivants :

- `BG-001` a `BG-005`
- `BG-101` a `BG-104`
- `BG-201` a `BG-203`
- `BG-207`
- `BG-301` a `BG-302`
- `BG-405`
- `BG-406`
- `BG-409`
- `BG-501` a `BG-504`
- `BG-701`
- `BG-702`
- `BG-704`
- `BG-901` a `BG-905`

Point important :
`BG-406` est ajoute au MVP valide car la creation des comptes etudiants est necessaire si l'on respecte l'absence d'auto-inscription.

## 7. Parcours de demonstration attendus

Le MVP doit permettre au minimum les demonstrations suivantes :

1. Un visiteur consulte les offres et les entreprises.
2. Un etudiant se connecte, consulte une offre, postule, puis voit sa liste de candidatures.
3. Un pilote se connecte et consulte les candidatures des etudiants de sa promotion.
4. Un role non autorise est bloque proprement sur une route protegee.

## 8. Criteres de validation du MVP

Le MVP peut etre considere comme valide si :

- les parcours du chapitre 7 fonctionnent de bout en bout,
- la matrice de permissions est respectee,
- les donnees critiques sont persistantes,
- les formulaires sensibles sont proteges,
- le rendu principal est exploitable sur desktop et mobile,
- la structure MVC et le recours a `PHP PDO` sont visibles et justifiables.

## 9. Decisions prises a ce stade

La validation du MVP retient les choix suivants :

- les statistiques publiques existent dans la matrice mais restent hors MVP,
- la wish-list reste hors MVP,
- la gestion complete des comptes pilotes reste hors MVP,
- la creation des comptes etudiants entre dans le MVP,
- le suivi pilote entre dans le MVP,
- les droits d'acces restent strictement alignes sur la matrice.

## 10. Statut propose

- `P1.3` : documente
- `Validation equipe` : a faire
- `Pret pour suite` : oui
