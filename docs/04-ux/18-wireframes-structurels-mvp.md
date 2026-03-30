# Wireframes structurels MVP

Ce document formalise le `Lot 4 - Wireframes structurels` pour les ecrans prioritaires du MVP.

Il ne cherche pas a definir le style visuel final. Il definit la structure fonctionnelle minimale que les wireframes devront respecter avant implementation.

## 1. Perimetre couvert

Le document couvre les ecrans des packs `A` a `D` definis dans [17-wireframes-prioritaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/17-wireframes-prioritaires.md).

Ecrans couverts :

- `V-PUB-001` accueil
- `V-PUB-004` login
- `V-PUB-005` liste des offres
- `V-PUB-006` detail offre
- `V-PUB-007` liste des entreprises
- `V-PUB-008` detail entreprise
- `V-ETU-004` candidature
- `V-ETU-005` liste des candidatures etudiant
- `V-PIL-001` dashboard pilote
- `V-PIL-002` liste des etudiants pilote
- `V-PIL-004` candidatures d'un etudiant cote pilote
- `V-PIL-006` creation de compte etudiant
- `V-SYS-001` `403`
- `V-SYS-002` `404`
- `V-SYS-003` `500`

## 2. Regles communes a tous les wireframes

- chaque ecran doit montrer clairement son titre de page,
- chaque ecran doit indiquer son contexte de role quand il est protege,
- chaque action principale doit etre unique et visuellement dominante,
- les actions interdites ne doivent pas apparaitre pour les roles non autorises,
- les etats `vide`, `erreur`, `succes` et `chargement` doivent etre prevus des la conception,
- la structure mobile doit etre definie en meme temps que la structure desktop,
- les zones de messages systeme doivent exister partout ou une action utilisateur peut echouer ou reussir.

## 3. Shells communs

### 3.1 Shell public

Blocs obligatoires :

- header public
- zone hero ou titre de page
- contenu principal
- footer

Structure desktop :

```text
+--------------------------------------------------------------+
| Header: Logo | Offres | Entreprises | Connexion              |
+--------------------------------------------------------------+
| Titre de page / Hero / Intro                                 |
+--------------------------------------------------------------+
| Contenu principal                                            |
|                                                              |
+--------------------------------------------------------------+
| Footer                                                       |
+--------------------------------------------------------------+
```

Structure mobile :

```text
+-----------------------------+
| Header compact + menu       |
+-----------------------------+
| Titre / Intro               |
+-----------------------------+
| Contenu principal           |
+-----------------------------+
| Footer compact              |
+-----------------------------+
```

### 3.2 Shell protege

Blocs obligatoires :

- header de role ou barre haute
- navigation secondaire ou laterale selon largeur
- titre de page
- zone messages
- contenu principal

Structure desktop :

```text
+--------------------------------------------------------------+
| Header role | Actions globales | Deconnexion                 |
+----------------------+---------------------------------------+
| Navigation role      | Titre de page                         |
| - item 1             +---------------------------------------+
| - item 2             | Messages systeme                      |
| - item 3             +---------------------------------------+
|                      | Contenu principal                     |
+----------------------+---------------------------------------+
```

Structure mobile :

```text
+-----------------------------+
| Header role + menu          |
+-----------------------------+
| Titre de page               |
+-----------------------------+
| Messages systeme            |
+-----------------------------+
| Contenu principal           |
+-----------------------------+
```

## 4. Pack A - Fondation publique

### 4.1 `V-PUB-001` Accueil

But :
orienter rapidement l'utilisateur vers les offres, les entreprises ou la connexion.

Blocs obligatoires :

- header public
- hero avec proposition de valeur
- deux CTA principaux : `Voir les offres`, `Voir les entreprises`
- bloc de reassurance ou resume fonctionnel
- bloc raccourci vers connexion
- footer

Structure desktop :

```text
+--------------------------------------------------------------+
| Header public                                                |
+--------------------------------------------------------------+
| Hero                                                         |
| Titre + texte court + CTA Offres + CTA Entreprises          |
+--------------------------------------------------------------+
| Bloc 1: Pourquoi utiliser InternHub                          |
| Bloc 2: Pour etudiants / pilotes / administrateurs           |
+--------------------------------------------------------------+
| Bloc connexion / acces rapide                                |
+--------------------------------------------------------------+
| Footer                                                       |
+--------------------------------------------------------------+
```

Etats requis :

- nominal
- utilisateur deja connecte

### 4.2 `V-PUB-004` Login

But :
authentifier proprement et rediriger selon le role.

Blocs obligatoires :

- header minimal
- titre `Connexion`
- formulaire email
- formulaire mot de passe
- bouton primaire `Se connecter`
- zone message erreur
- lien retour accueil

Structure desktop :

```text
+--------------------------------------------------------------+
| Header minimal                                               |
+--------------------------------------------------------------+
| Carte centrale                                               |
| Titre                                                        |
| Message d'aide                                               |
| [Email]                                                      |
| [Mot de passe]                                               |
| [Bouton Se connecter]                                        |
| Zone erreur / info                                           |
| Lien retour accueil                                          |
+--------------------------------------------------------------+
```

Etats requis :

- vide
- erreurs champs
- erreur authentification
- session expiree
- chargement

### 4.3 `V-SYS-001` `403`

Blocs obligatoires :

- code erreur
- message clair
- CTA retour contexte
- CTA retour accueil

### 4.4 `V-SYS-002` `404`

Blocs obligatoires :

- code erreur
- message ressource introuvable
- CTA retour accueil
- CTA retour liste pertinente si contexte connu

### 4.5 `V-SYS-003` `500`

Blocs obligatoires :

- code erreur
- message erreur technique
- CTA retour accueil

Structure commune des pages erreur :

```text
+--------------------------------------------------------------+
| Header minimal ou aucun header                               |
+--------------------------------------------------------------+
| Code erreur grand format                                     |
| Titre explicite                                              |
| Texte court                                                  |
| CTA principal                                                |
| CTA secondaire                                               |
+--------------------------------------------------------------+
```

## 5. Pack B - Consultation

### 5.1 `V-PUB-005` Liste des offres

But :
rechercher, filtrer et ouvrir une offre.

Blocs obligatoires :

- header public ou de role
- titre de page
- barre de filtres
- resume des resultats
- liste d'offres
- pagination
- etat vide

Structure desktop :

```text
+--------------------------------------------------------------+
| Header                                                       |
+--------------------------------------------------------------+
| Titre page + texte d'aide                                    |
+--------------------------------------------------------------+
| Filtres: recherche | localisation | competences | contrat    |
+--------------------------------------------------------------+
| Resume resultats + tri                                       |
+--------------------------------------------------------------+
| Carte offre 1                                                |
| Carte offre 2                                                |
| Carte offre 3                                                |
+--------------------------------------------------------------+
| Pagination                                                   |
+--------------------------------------------------------------+
```

Structure mobile :

- filtres collapsibles ou empiles,
- cartes sur une colonne,
- pagination simplifiee.

Etats requis :

- liste nominale
- aucun resultat
- erreur chargement

### 5.2 `V-PUB-006` Detail offre

But :
montrer les informations de l'offre et proposer l'action correcte selon le role.

Blocs obligatoires :

- breadcrumb ou lien retour
- titre offre
- meta informations cle
- bloc entreprise associee
- description mission
- competences
- CTA principal contextuel
- CTA secondaire retour liste

Structure desktop :

```text
+--------------------------------------------------------------+
| Header                                                       |
+--------------------------------------------------------------+
| Lien retour liste offres                                     |
+--------------------------------------------------------------+
| Colonne principale                  | Colonne laterale        |
| Titre offre                         | Entreprise              |
| Resume mission                      | Meta infos              |
| Description                         | CTA principal           |
| Competences                         | CTA secondaire          |
+--------------------------------------------------------------+
```

CTA selon role :

- `Anonyme` : `Se connecter pour postuler`
- `Etudiant` : `Postuler`
- `Pilote` et `Administrateur` : pas de CTA candidature

Etats requis :

- nominal
- offre introuvable
- action deja effectuee cote etudiant si necessaire

### 5.3 `V-PUB-007` Liste des entreprises

Blocs obligatoires :

- titre page
- filtres simples
- resume resultats
- liste entreprise
- pagination

Structure similaire a la liste des offres, avec cartes plus compactes.

### 5.4 `V-PUB-008` Detail entreprise

Blocs obligatoires :

- retour liste entreprises
- titre entreprise
- resume entreprise
- coordonnees selon regle de visibilite retenue
- bloc offres associees
- bloc appreciation seulement si permis et retenu

Structure desktop :

```text
+--------------------------------------------------------------+
| Header                                                       |
+--------------------------------------------------------------+
| Retour liste entreprises                                     |
+--------------------------------------------------------------+
| Infos entreprise                   | Actions contextuelles    |
| Presentation                       |                          |
+--------------------------------------------------------------+
| Offres associees                                              |
+--------------------------------------------------------------+
```

## 6. Pack C - Candidature etudiant

### 6.1 `V-ETU-004` Candidature

But :
soumettre une candidature sans ambiguite.

Blocs obligatoires :

- header etudiant ou header role
- retour detail offre
- rappel synthese de l'offre
- message d'instruction
- champ lettre de motivation ou zone equivalente
- bloc upload CV
- zone messages erreur
- bouton primaire `Envoyer ma candidature`
- bouton secondaire `Annuler`

Structure desktop :

```text
+--------------------------------------------------------------+
| Header role                                                  |
+--------------------------------------------------------------+
| Retour detail offre                                          |
+--------------------------------------------------------------+
| Resume offre                                                 |
+--------------------------------------------------------------+
| Formulaire                                                   |
| [Lettre de motivation / zone texte ou indication]            |
| [Upload CV]                                                  |
| Messages d'erreur                                            |
| [Envoyer ma candidature] [Annuler]                           |
+--------------------------------------------------------------+
```

Etats requis :

- vide
- champ invalide
- fichier refuse
- doublon candidature
- succes
- erreur technique

### 6.2 `V-ETU-005` Liste des candidatures etudiant

But :
permettre a l'etudiant de suivre ses envois.

Blocs obligatoires :

- header role
- titre page
- liste ou tableau de candidatures
- colonnes ou cartes : offre, entreprise, date, statut
- liens vers offre associee
- etat vide

Structure desktop :

```text
+--------------------------------------------------------------+
| Header role                                                  |
+--------------------------------------------------------------+
| Titre + texte court                                          |
+--------------------------------------------------------------+
| Tableau ou cartes                                            |
| Offre | Entreprise | Date | Statut | Action                  |
+--------------------------------------------------------------+
```

Etats requis :

- liste nominale
- aucune candidature
- erreur chargement

## 7. Pack D - Supervision pilote

### 7.1 `V-PIL-001` Dashboard pilote

But :
servir de hub de supervision.

Blocs obligatoires :

- shell protege pilote
- titre `Dashboard pilote`
- tuiles ou cartes de raccourci
- resume nombre d'etudiants
- resume candidatures recentes
- CTA vers liste etudiants

Structure desktop :

```text
+--------------------------------------------------------------+
| Header pilote                                                |
+----------------------+---------------------------------------+
| Nav pilote           | Titre dashboard                       |
|                      +---------------------------------------+
|                      | Cartes KPI / raccourcis               |
|                      +---------------------------------------+
|                      | Activite recente / liens utiles       |
+----------------------+---------------------------------------+
```

### 7.2 `V-PIL-002` Liste des etudiants pilote

But :
lister et filtrer les etudiants de la promotion.

Blocs obligatoires :

- shell protege pilote
- titre page
- bouton `Creer un compte etudiant`
- filtres simples
- tableau des etudiants
- pagination si necessaire

Colonnes minimum :

- nom
- promo
- etat de recherche si disponible
- action `Voir`

### 7.3 `V-PIL-004` Candidatures d'un etudiant cote pilote

But :
consulter les candidatures d'un etudiant autorise.

Blocs obligatoires :

- shell protege pilote
- contexte etudiant
- retour liste etudiants
- tableau ou liste des candidatures
- actions documentaires si retenues

Colonnes minimum :

- offre
- entreprise
- date
- document disponible
- action

Etats requis :

- etudiant hors promo -> `403`
- aucune candidature

### 7.4 `V-PIL-006` Creation de compte etudiant

But :
permettre au pilote de creer un compte etudiant conforme.

Blocs obligatoires :

- shell protege pilote
- retour liste etudiants
- titre page
- formulaire creation compte
- zone message
- bouton primaire `Creer le compte`
- bouton secondaire `Annuler`

Champs minimum a prevoir :

- nom
- prenom
- email
- promo
- mot de passe initial ou mecanisme retenu

Etats requis :

- vide
- erreurs champs
- email deja utilise
- succes creation
- erreur technique

## 8. Notes responsive

Pour tous les wireframes MVP :

- passer en une colonne sur mobile,
- transformer les tableaux critiques en cartes ou lignes empilees si necessaire,
- conserver le CTA principal visible sans scroll excessif,
- faire passer les filtres en bloc repliable sur mobile,
- garder les messages systeme proches du formulaire ou de l'action declenchante.

## 9. Definition of Done du Lot 4

Le `Lot 4` sera considere comme suffisamment prepare si :

- chaque ecran ci-dessus possede un wireframe desktop et mobile,
- les blocs obligatoires sont representes,
- les CTA principaux et secondaires sont identifies,
- les etats critiques sont notes sur chaque ecran,
- les differences de role sont visibles dans les actions,
- un developpeur peut implementer la structure sans devoir reinventer la page.
