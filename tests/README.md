# Tests

Ce dossier est reserve aux tests applicatifs du projet.

Socle unitaire minimal ajoute dans `P8.4` :

- `php tools/composer.phar test`
- ou `./vendor/bin/phpunit`

Ce lot couvre actuellement :

- `Config`
- `Request`
- `Router`
- `Auth` et middleware d acces

Il complete les smoke tests HTTP, il ne les remplace pas.

Pour le `P5`, la verification minimale a faire est :

- `php -l public/index.php`
- `php -l bootstrap.php`
- verification HTTP du front controller et de la route `/health`

Pour le premier slice `P6`, ajouter :

- `php database/init-sqlite.php`
- verification HTTP de `/login`, `/offres`, `/entreprises`
- verification de la connexion avec les comptes de demo

Pour cloturer `P6`, utiliser le smoke test complet :

- `bash tests/smoke/p6_http_smoke.sh`

Ce script :

- initialise la base SQLite locale,
- demarre le serveur PHP embarque,
- verifie les routes publiques,
- verifie les redirects et dashboards par role,
- verifie les gestions `comptes`, `entreprises`, `offres`,
- verifie les gardes `403` et les blocages de suppression,
- nettoie ses donnees temporaires a la fin.

Pour verifier `P7.1` candidature complete :

- `bash tests/smoke/p7_candidatures_smoke.sh`

Ce script :

- verifie la fiche candidature cote etudiant,
- verifie le telechargement securise du CV cote etudiant,
- verifie la fiche candidature cote pilote,
- verifie le telechargement securise du CV cote pilote,
- verifie les refus d'acces hors perimetre et hors promotion.

Pour verifier `P7.2` wish-list :

- `bash tests/smoke/p7_wishlist_smoke.sh`

Ce script :

- verifie l'ajout d'une offre a la wish-list,
- verifie le blocage des doublons,
- verifie l'affichage de la liste,
- verifie le retrait d'une offre.

Pour verifier `P7.3` suivi pilote :

- `bash tests/smoke/p7_pilot_followup_smoke.sh`

Ce script :

- verifie le dashboard pilote enrichi,
- verifie la fiche etudiant cote pilote,
- verifie les blocages hors promotion sur les routes derivees.

Pour verifier `P7.4` statistiques :

- `bash tests/smoke/p7_statistics_smoke.sh`

Ce script :

- verifie l acces public a `/statistiques`,
- verifie les principaux indicateurs affiches,
- verifie l acces a la page pour `etudiant`, `pilote` et `administrateur`.

Pour verifier `P7.5` profil etudiant :

- `bash tests/smoke/p7_student_profile_smoke.sh`

Ce script :

- verifie l acces au profil etudiant,
- verifie la mise a jour des informations personnelles,
- verifie la mise a jour optionnelle du mot de passe,
- verifie qu une nouvelle connexion fonctionne avec les identifiants modifies.

Pour cloturer `P7`, utiliser le smoke test de phase :

- `bash tests/smoke/p7_http_smoke.sh`

Ce script :

- execute les smoke tests `P7.1` a `P7.5` dans l ordre,
- verifie que les modules avances restent validables en suite complete,
- fournit une porte de sortie unique pour la verification de phase.

Pour cloturer `P8`, utiliser le smoke test de phase :

- `bash tests/smoke/p8_http_smoke.sh`

Ce script :

- relance `PHPUnit`,
- rejoue les smoke tests complets `P6` et `P7`,
- verifie les metas HTML et la page `Mentions legales`,
- confirme le retrait de `Health` de la navigation principale,
- fournit une porte de sortie unique pour la verification complete de `P8`.
