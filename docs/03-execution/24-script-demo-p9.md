# P9.1 Script de demo

Ce document fixe le script officiel de demonstration pour `InternHub`.

L objectif n est pas de tout montrer. L objectif est de montrer juste assez pour prouver que :

- le produit couvre les parcours coeur,
- les roles sont bien separes,
- les modules metier fonctionnent de bout en bout,
- le projet est stable et defendable techniquement.

## 1. Format recommande

Format cible :

- duree ideale : `8 a 10 minutes`,
- duree maximale : `12 minutes`,
- demonstration guidee, sans improvisation,
- un seul fil narratif : de la consultation publique jusqu a la supervision.

## 2. Comptes de demonstration

Jeu de comptes a utiliser pendant la soutenance :

- `student@internhub.test` / `Student123!`
- `pilot@internhub.test` / `Pilot123!`
- `admin@internhub.test` / `Admin123!`

Jeu de donnees visible dans la base locale :

- `3` entreprises initiales,
- `4` offres publiees,
- `2` candidatures deja deposees par `Emma Student`,
- statistiques publiques non vides,
- promotion `Promotion 2026` avec au moins un pilote et deux etudiants.

## 3. Fil narratif a tenir

Message directeur a conserver pendant toute la demo :

`InternHub` permet de consulter des offres, candidater, suivre les etudiants d une promotion et administrer les comptes, le tout avec des droits separes et des controles verifies.

## 4. Script minute par minute

### Sequence 1. Ouverture publique

Duree cible :

- `1 min 30`

Ecrans :

1. `/`
2. `/offres`
3. `/offres/1`
4. `/entreprises/1`
5. `/statistiques`

Ce qu il faut montrer :

- la page d accueil presente le perimetre reel de l application,
- les offres sont consultables sans connexion,
- une fiche offre detaillee est disponible,
- une fiche entreprise detaillee est disponible,
- les statistiques publiques sont anonymisees et non vides.

Ce qu il faut dire :

- le visiteur peut consulter sans compte,
- la consultation publique couvre les offres, les entreprises et la vision statistique,
- les donnees globales n exposent pas de donnees personnelles.

### Sequence 2. Parcours etudiant

Duree cible :

- `2 min`

Ecrans :

1. `/login`
2. connexion `student@internhub.test`
3. `/dashboard/etudiant`
4. `/dashboard/etudiant/candidatures`
5. `/dashboard/etudiant/candidatures/1`
6. `/dashboard/etudiant/wishlist`
7. `/dashboard/etudiant/profil`

Ce qu il faut montrer :

- redirection automatique vers le bon dashboard apres connexion,
- dashboard avec indicateurs personnels,
- liste des candidatures deja deposees,
- detail d une candidature et telechargement du CV,
- wish-list etudiant,
- edition du profil.

Ce qu il faut dire :

- les droits sont adaptes au role,
- l etudiant peut suivre ses candidatures sans voir celles des autres,
- le CV reste telechargeable uniquement dans son perimetre,
- le profil est modifiable sans exposer les champs sensibles comme le role.

### Sequence 3. Parcours pilote

Duree cible :

- `2 min 30`

Ecrans :

1. deconnexion
2. connexion `pilot@internhub.test`
3. `/dashboard/pilote`
4. `/dashboard/pilote/etudiants`
5. `/dashboard/pilote/etudiants/1`
6. `/dashboard/pilote/etudiants/1/candidatures`
7. `/dashboard/pilote/entreprises`
8. `/dashboard/pilote/offres`

Ce qu il faut montrer :

- dashboard pilote avec vue de supervision,
- liste des etudiants de la promotion,
- fiche etudiant et candidatures associees,
- acces pilote a la gestion des entreprises,
- acces pilote a la gestion des offres.

Ce qu il faut dire :

- le pilote ne voit que sa promotion,
- le suivi pedagogique passe par la vue etudiant et la vue candidature,
- le pilote peut preparer le terrain metier en gerant entreprises et offres,
- les gardes hors promotion et hors role ont ete verifies par smoke tests.

### Sequence 4. Parcours administrateur

Duree cible :

- `1 min 30`

Ecrans :

1. deconnexion
2. connexion `admin@internhub.test`
3. `/dashboard/admin`
4. `/admin/comptes`
5. `/admin/entreprises`
6. `/admin/offres`

Ce qu il faut montrer :

- dashboard admin avec vision transversale,
- gestion des comptes,
- gestion des entreprises,
- gestion des offres.

Ce qu il faut dire :

- l administrateur ne suit pas une promotion, il supervise la structure globale,
- il gere les comptes et les entites transverses,
- les routes sont separees de celles du pilote.

### Sequence 5. Cloture qualite

Duree cible :

- `1 min`

Ecrans ou supports :

1. rappel du protocole `tests/smoke/p8_http_smoke.sh`
2. rappel des protections : `CSRF`, roles, erreurs `403/404/500`

Ce qu il faut dire :

- la demo ne repose pas seulement sur des clics manuels,
- le projet dispose d un socle `PHPUnit`,
- `P6`, `P7` et `P8` sont rejouables par scripts,
- la stabilisation fait partie du livrable, pas seulement la feature list.

## 5. Version courte si le temps se resserre

Si la soutenance est plus courte que prevu, couper dans cet ordre :

1. reduire la sequence publique a `/offres`, `/offres/1`, `/statistiques`
2. ne montrer qu une seule vue detaillee cote etudiant
3. ne montrer cote pilote que `dashboard` puis `etudiants/1/candidatures`
4. ne montrer cote admin que `dashboard` puis `comptes`

Ne pas couper :

- la separation des roles,
- une preuve de candidature existante,
- une preuve de supervision pilote,
- une preuve de gestion admin,
- la mention des tests et de la stabilisation.

## 6. Recommandations d execution

Avant la demo :

- reinitialiser la base locale avec `php database/init-sqlite.php`,
- verifier que les comptes de demo fonctionnent,
- ouvrir l application sur la page d accueil,
- fermer les onglets inutiles,
- ne pas improviser de creation destructive en direct si elle n est pas necessaire au script.

Pendant la demo :

- toujours annoncer le role courant,
- toujours expliquer pourquoi la page montree existe,
- rester sur les parcours prepares,
- ne pas naviguer au hasard dans le header.

## 7. Definition of Done de P9.1

`P9.1` pourra etre consideree comme terminee si :

- un script officiel de demo existe,
- les comptes de demonstration sont figes,
- l ordre de passage des roles est defini,
- les pages a ouvrir sont connues a l avance,
- une version courte existe en cas de contrainte de temps.

## 8. Prochaine action

Passer a `P9.2 Jeu de donnees et comptes de demo`.
