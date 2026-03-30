# Zones a clarifier

Ce document recense les ambiguites et les hypotheses a valider au plus tot afin de limiter les reworks.

## 1. Incoherences ou manques dans le sujet

### 1.1 Nombre de phases

Constat :
Le sujet mentionne `4 temps` mais detaille `6 phases`.

Recommandation :
Retenir officiellement `6 phases` dans l'organisation interne, car c'est le decoupage le plus precis.

### 1.2 Fonctionnalite manquante

Constat :
Le code `SFx26` n'apparait pas dans le cahier des charges.

Recommandation :
Le laisser reserve et ne pas le reattribuer sans validation.

### 1.3 Permissions absentes pour les fonctions transversales

Constat :
`SFx27` et `SFx28` ne figurent pas dans la matrice.

Recommandation :

- `SFx27` doit s'appliquer aux interfaces concernees, sans notion de role specifique.
- `SFx28` doit etre accessible publiquement.

## 2. Ambiguities fonctionnelles

### 2.1 Qui peut evaluer une entreprise ?

Constat :
La matrice autorise `Administrateur` et `Pilote`, mais pas `Etudiant`.

Question :
L'intention fonctionnelle est-elle vraiment d'exclure les etudiants de l'evaluation alors qu'ils vivent l'experience du stage ?

Hypothese de travail :
Conserver et implementer la matrice telle quelle. Sans nouvelle version officielle de la matrice, les droits d'acces ne doivent pas etre modifies.

### 2.2 Les statistiques doivent-elles etre publiques ?

Constat :
La matrice rend `SFx11` accessible aux anonymes.

Question :
Le client souhaite-t-il vraiment exposer les statistiques sans authentification ?

Hypothese de travail :
Implementer l'acces public a `SFx11`, puisque la matrice l'autorise explicitement. Si un changement est demande plus tard, il devra passer par une mise a jour officielle de la matrice ou une decision projet tracee.

### 2.3 Visibilite des coordonnees d'entreprise

Constat :
Les donnees incluent email et telephone de contact.

Question :
Ces donnees sont-elles visibles par tous les utilisateurs, y compris anonymes, ou reservees aux comptes connectes ?

Hypothese de travail :
Afficher publiquement le strict necessaire, et reserver les details de contact aux utilisateurs connectes si besoin.

### 2.4 Gestion des competences

Constat :
Le sujet indique qu'il faut reflechir a la meilleure maniere de gerer les competences et qu'il n'est pas necessaire de modifier la liste.

Recommandation :
Utiliser un referentiel ferme de competences, alimente par seed ou script SQL, non editable depuis l'interface.

### 2.5 Nature de la suppression

Constat :
Le sujet parle de suppression d'entreprises, d'offres et de comptes, sans preciser suppression logique ou physique.

Hypothese de travail :
Preferer une desactivation logique pour conserver l'historique et eviter de casser les relations.

### 2.6 Gestion des candidatures

Questions a trancher :

- un etudiant peut-il postuler plusieurs fois a la meme offre ?
- quels formats de fichiers sont acceptes pour CV et lettre ?
- quelle taille maximale de fichier ?
- la lettre de motivation est-elle un champ texte, un fichier, ou les deux ?

Hypothese de travail :

- une seule candidature par offre et par etudiant,
- CV en PDF,
- lettre de motivation en texte ou PDF selon la complexite retenue.

### 2.7 Perimetre du compte etudiant

Question :
Un etudiant peut-il consulter sa propre fiche detaillee via `SFx16`, ou cette fonctionnalite est-elle reservee a l'administrateur et au pilote ?

Hypothese de travail :
Prevoir une page "Mon profil" distincte si necessaire, meme si `SFx16` reste une fonction d'administration/suivi.

## 3. Ambiguities techniques

### 3.1 Cookies securises

Constat :
Le sujet demande que les informations de connexion soient stockees dans des cookies securises.

Interpretation recommandee :
Utiliser des sessions serveur PHP avec cookie de session securise (`HttpOnly`, `Secure`, `SameSite`) plutot que stocker des donnees sensibles cote client.

### 3.2 Moteur de template

Question :
Le choix est-il libre tant qu'il reste compatible avec la contrainte "pas de framework" ?

Hypothese de travail :
Mettre en place un moteur simple maison ou une approche de templates PHP propres avec includes de fragments, si cela est accepte pedagogiquement.

### 3.3 Vhost statique

Question :
Le vhost dedie aux assets est-il une contrainte evaluee dans l'environnement reel de soutenance ou seulement une recommandation d'architecture ?

Hypothese de travail :
Documenter la cible d'architecture meme si l'environnement de dev reste simplifie.

## 4. Decisions recommandees des maintenant

- Adopter une architecture MVC stricte des le debut.
- Utiliser un referentiel ferme de competences.
- Definir un MVP centre sur la consultation, l'authentification et les candidatures.
- Prevoir une suppression logique pour les entites metier principales.
- Documenter toute divergence entre cahier des charges et implementation.

## 5. Statut

Ce document doit etre revu en reunion d'equipe. Chaque point devrait recevoir l'un des statuts suivants :

- valide,
- a arbitrer,
- en attente d'information client,
- abandonne.
