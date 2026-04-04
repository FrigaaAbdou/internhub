# Questions-reponses approfondies pour le jury

Ce document rassemble des questions de soutenance plus exigeantes que les simples questions de perimetre fonctionnel.

L'objectif est de preparer l'equipe a :

- justifier les notions utilisees,
- expliquer les choix techniques,
- commenter l'architecture et le code,
- defendre les ecarts entre conception, implementation et planification,
- et montrer une vraie comprehension du projet.

Les reponses ci-dessous sont volontairement :

- courtes,
- defendables,
- et compatibles avec l'etat reel du depot.

## 1. Architecture et decoupage du code

### Pourquoi avoir separe `Controller`, `Repository` et `View` ?

Parce que ces couches n'ont pas la meme responsabilite :

- le `Controller` orchestre la requete HTTP,
- le `Repository` centralise l'acces aux donnees,
- la `View` affiche les donnees.

Cette separation rend le projet plus lisible, plus testable, et limite les duplications.

### Quelle difference concrete faites-vous entre un controleur et un repository ?

Le controleur repond a une action utilisateur, par exemple afficher une page ou traiter un formulaire.
Le repository sait interroger la base et retourner les donnees utiles.

Le controleur ne devrait pas contenir du SQL, et le repository ne devrait pas gerer la navigation ou les redirections.

### Pourquoi dites-vous que l'application est vraiment en `MVC` ?

Parce que la structure ne se limite pas a des dossiers nommes `Models`, `Views` et `Controllers`.

On retrouve une vraie separation :

- `Router` et front controller pour l'entree HTTP,
- controleurs pour l'orchestration,
- vues serveur pour l'affichage,
- repositories pour l'acces base.

Cette separation est visible dans l'arborescence et dans le flux d'execution.

### Pourquoi la logique metier ne doit-elle pas etre dans les vues ?

Parce qu'une vue doit uniquement afficher des donnees.
Si on y met de la logique metier, on rend le projet plus fragile, plus difficile a relire et plus difficile a faire evoluer.

### Pourquoi avoir utilise `PDO` et pas `mysqli` ?

`PDO` fournit une abstraction standard, propre, et compatible avec plusieurs moteurs SQL.
Il permet aussi l'usage naturel des requetes preparees, ce qui est important pour la securite et la lisibilite.

### Pourquoi avoir choisi un rendu HTML cote serveur plutot qu'un front SPA ?

Parce que le sujet interdit les frameworks front modernes, et parce que le perimetre du projet se prete bien a un rendu serveur.
Ce choix reduit la complexite et permet de concentrer l'effort sur les droits, les parcours et la logique metier.

### Quel est le role du front controller ?

Le front controller est le point d'entree unique de l'application.
Il recoit la requete HTTP, charge le socle applicatif, puis confie la resolution au routeur.

### Comment une requete traverse-t-elle l'application ?

Le navigateur appelle une URL.
Cette URL entre par le front controller, puis le routeur la fait correspondre a un controleur et a une action.
Le controleur appelle un ou plusieurs repositories, prepare les donnees, puis rend une vue ou une reponse HTTP.

## 2. Questions de code

### Que fait exactement un controleur comme `OfferController` ?

Il gere le domaine fonctionnel des offres :

- liste publique,
- detail public,
- ecrans de gestion,
- creation,
- modification,
- suppression.

Il fait le lien entre la requete HTTP, les donnees renvoyees par le repository, et la vue finale.

### Pourquoi cette logique est-elle dans ce controleur et pas dans un autre ?

Parce qu'elle appartient au domaine fonctionnel de l'offre.
Le critere n'est pas seulement technique, il est metier :
chaque controleur est organise autour d'un domaine ou d'un usage.

### Pourquoi cette logique est-elle dans un repository et pas dans le controleur ?

Parce qu'il s'agit d'acces ou de composition de donnees.
Un repository doit regrouper les requetes et les lectures de base pour eviter le SQL disperse.

### Pourquoi certaines vues creation et edition partagent le meme fichier ?

Parce que la structure du formulaire est la meme.
Le mode creation ou edition change surtout :

- le titre,
- les valeurs par defaut,
- l'action de soumission,
- et certains textes d'interface.

Cela limite la duplication et garde un comportement coherent.

### Pourquoi l'ordre des routes peut-il etre critique ?

Parce que le routeur travaille par premier matching.
Si une route dynamique comme `/dashboard/pilote/etudiants/{id}` passe avant `/dashboard/pilote/etudiants/create`, alors `create` peut etre interprete comme un identifiant.

### Si une regle metier change, ou faut-il intervenir ?

Cela depend :

- si c'est une regle d'acces, on regarde middleware et controleurs,
- si c'est une regle de lecture ou d'ecriture des donnees, on regarde les repositories,
- si c'est une question de presentation, on regarde les vues.

## 3. Permissions et securite

### Pourquoi ne suffit-il pas de cacher les boutons dans l'interface ?

Parce qu'un utilisateur peut toujours taper directement une URL.
La vraie securite doit etre appliquee cote serveur sur les routes et les actions.

### Quelle difference faites-vous entre authentification et autorisation ?

- l'authentification verifie l'identite,
- l'autorisation verifie le droit d'acceder a une ressource ou a une action.

### Pourquoi afficher parfois `403` et parfois rediriger vers `login` ?

- si l'utilisateur n'est pas connecte, on le redirige vers `login`,
- s'il est connecte mais non autorise, on renvoie `403`.

Cela permet de distinguer absence d'authentification et refus de permission.

### Quelle difference faites-vous entre verifier un role et verifier un perimetre metier ?

Verifier le role consiste a verifier si l'utilisateur est `etudiant`, `pilote` ou `administrateur`.
Verifier le perimetre metier consiste a verifier si la ressource fait bien partie de son champ d'action, par exemple un etudiant de la promotion du pilote.

### Comment protegez-vous les formulaires ?

Les formulaires sensibles sont proteges par `CSRF`.
Un token est injecte dans le formulaire puis verifie cote serveur avant traitement.

### Pourquoi la validation front ne suffit-elle pas ?

Parce que le front peut etre contourne ou modifie.
La validation cote serveur reste la seule validation fiable.

### Comment les mots de passe sont-ils proteges ?

Ils sont stockes sous forme de hash, pas en clair.
L'application ne conserve pas le mot de passe brut en base.

### Pourquoi stocker les CV hors du dossier public ?

Pour eviter qu'un fichier soit accessible directement par URL sans controle.
Le telechargement passe alors par une route protegee.

## 4. MCD, MLD et base de donnees

### Pourquoi `Anonyme` n'apparait-il pas dans le `MCD` ?

Parce que `Anonyme` n'est pas une entite stockee en base.
C'est un profil d'acces applicatif, pas un objet metier persistant.

### Pourquoi `Administrateur`, `Pilote` et `Etudiant` sont-ils dans une seule entite `UTILISATEUR` ?

Parce qu'ils partagent le meme socle de donnees :

- nom,
- prenom,
- email,
- mot de passe,
- date de creation.

Le role permet ensuite de distinguer les droits.

### Pourquoi `CANDIDATURE` et `WISHLIST` deviennent-elles de vraies tables ?

Parce qu'il s'agit d'associations porteuses de sens metier et d'attributs.

Par exemple, une candidature contient :

- une lettre de motivation,
- un CV,
- un statut,
- une date.

### Pourquoi une offre doit-elle obligatoirement appartenir a une entreprise ?

Parce qu'une offre de stage n'existe pas metierement sans entreprise emettrice.
Le lien n'est pas optionnel dans le modele logique.

### Pourquoi certaines choses sont dans le `MCD` mais pas dans la base actuelle ?

Parce que le `MCD` represente le besoin metier complet, tandis que la base actuelle represente l'etat reel de l'implementation.
L'exemple typique est `SFx5` sur l'evaluation d'entreprise, presente conceptuellement mais non encore implantee physiquement.

### Pourquoi avoir mis une unicite sur `(id_etudiant, id_offre)` ?

Pour traduire la regle :
un etudiant ne peut pas candidater deux fois a la meme offre.

La meme logique s'applique a la wish-list pour eviter les doublons.

### Qu'apporte une cle etrangere ici ?

Elle garantit la coherence des liens entre tables.
Par exemple :

- une offre reference une entreprise existante,
- une candidature reference un etudiant et une offre existants.

## 5. Tests et verification

### Pourquoi combiner `PHPUnit` et smoke tests ?

Parce qu'ils ne couvrent pas le meme niveau.

- `PHPUnit` teste des briques isolees,
- les smoke tests verifient des parcours HTTP complets.

### Qu'est-ce qu'un smoke test verifie qu'un test unitaire ne verifie pas ?

Il verifie qu'un parcours reel fonctionne de bout en bout :

- route,
- middleware,
- controleur,
- vue,
- session,
- redirection,
- code HTTP.

### Pourquoi ne pas avoir tout teste uniquement avec des tests unitaires ?

Parce qu'un projet web avec beaucoup de logique de navigation gagne a etre verifie aussi en conditions reelles.
Les smoke tests apportent une verification plus proche de la demo.

### Comment savez-vous que la demo sera stable ?

Parce que :

- les comptes de demo sont figes,
- les donnees de demo sont resettable,
- les scripts de verification sont rejouables,
- et les parcours critiques ont ete testés.

### Que ne couvrent pas encore vos tests ?

Ils ne couvrent pas toute l'application au niveau unitaire.
La couverture est suffisante pour une soutenance, mais pas exhaustive comme sur un produit industrialise.

## 6. Gestion de projet

### Pourquoi avoir utilise `PERT` en plus du `Gantt` ?

Parce qu'ils n'ont pas le meme role :

- `PERT` sert a visualiser les dependances et le chemin critique,
- `Gantt` sert a visualiser le planning, les chevauchements et la repartition dans le temps.

### Comment avez-vous identifie le chemin critique ?

En regardant quelles taches conditionnaient directement les autres :

- cadrage,
- modelisation,
- structure applicative,
- authentification,
- puis parcours metier coeur.

### Comment la documentation a-t-elle servi concretement au groupe ?

Elle a servi a :

- partager les decisions,
- clarifier les roles,
- aligner l'UX, le backend et la base,
- et permettre a chacun de reprendre plus facilement le travail d'un autre.

### Comment avez-vous choisi le `MVP` ?

Nous avons priorise le parcours le plus demonstrable :

- consulter une offre,
- se connecter,
- candidater,
- suivre les candidatures,
- superviser cote pilote,
- gerer la structure cote admin.

## 7. Justification des ecarts entre planning previsionnel et planning reel

### Pourquoi y a-t-il un ecart entre le planning prevu et le planning reel ?

Parce qu'un planning previsionnel sert a structurer le projet, pas a predire parfaitement chaque detail d'execution.

Dans notre cas, les principaux ecarts viennent de trois facteurs :

1. certaines zones du cahier des charges etaient ambiguës et ont demande une phase de clarification plus forte que prevu,
2. la stabilisation technique et la verification ont pris plus de place que sur un planning theorique,
3. certaines fonctionnalites se sont revelees plus dependantes les unes des autres que ce qui semblait apparaitre au premier niveau.

### Comment justifiez-vous ces ecarts de maniere serieuse ?

On les justifie par une logique de pilotage :

- le planning initial a servi de cadre,
- puis il a ete reajuste en fonction des dependances reelles,
- de la priorisation du `MVP`,
- et des risques techniques observes pendant le developpement.

L'objectif n'etait pas de suivre le planning de facon rigide, mais de livrer un produit coherent, testable et defendable.

### Quels ecarts sont les plus faciles a expliquer ?

- la conception et la clarification du besoin ont pris plus de temps qu'un planning brut ne le laisse penser,
- certaines parties UI/UX ont ete reprises par familles de pages pour garder de la coherence,
- la phase de verification finale a ete plus large parce qu'on a voulu fiabiliser la demo.

### Pourquoi ces ecarts ne sont-ils pas un echec de gestion ?

Parce qu'ils ont ete arbitres, documentes et assumes.
Le projet n'a pas derive sans controle :

- il a ete re-priorise,
- les dependances ont ete relues,
- les livrables ont ete stabilises par phases.

Autrement dit, il y a eu adaptation du planning, pas abandon du pilotage.

### Formulation courte defendable

`Le planning previsionnel nous a servi de cadre initial, mais nous l'avons reajuste en fonction des dependances reelles, de la clarification du besoin et du temps necessaire a la stabilisation. L'ecart principal ne vient pas d'un manque d'organisation, mais du fait qu'un projet reel demande des arbitrages entre fonctionnalites, coherence globale et fiabilite de la demo.`

## 8. Questions critiques qu'il faut savoir gerer

### Quel est aujourd'hui le point le plus fragile du projet ?

Le point le plus fragile n'est pas le parcours coeur, mais les limites de durcissement production.
Le projet est stabilise pour une soutenance, pas industrialise comme un SaaS complet.

### Qu'est-ce que vous changeriez en premier pour une vraie mise en production ?

On renforcerait :

- le moteur SQL cible,
- les contraintes de base,
- la validation de fichiers,
- la couverture de tests,
- et l'exploitation serveur.

### Quel choix referiez-vous pareil ?

La separation des roles, le decoupage par domaines, et la priorisation du parcours candidature.

### Quel choix referiez-vous autrement ?

On figerait plus tot le modele physique cible si la contrainte SGBD devait etre strictement imposée des le depart.

## 9. Conclusion courte

La ligne de defense generale est la suivante :

`Nous ne defendons pas un projet parfait. Nous defendons un projet compris, structure, implemente et verifie. Nous sommes capables d'expliquer les notions utilisees, les choix d'architecture, les ecarts entre la conception et l'implementation, ainsi que les arbitrages de planning qui nous ont permis de livrer un resultat coherent.`
