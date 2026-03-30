# P8.4 - socle de tests automatise minimal

Ce document acte la mise en place du socle de tests automatise minimal de `P8.4`.

## 1. Livrables ajoutes

Socle outillage :

- [composer.json](/Users/abdoufrigaa/Projects/internhub/composer.json)
- [composer.lock](/Users/abdoufrigaa/Projects/internhub/composer.lock)
- [phpunit.xml](/Users/abdoufrigaa/Projects/internhub/phpunit.xml)
- [bootstrap.php](/Users/abdoufrigaa/Projects/internhub/tests/bootstrap.php)

Premiere suite unitaire :

- [ConfigTest.php](/Users/abdoufrigaa/Projects/internhub/tests/Unit/ConfigTest.php)
- [RequestTest.php](/Users/abdoufrigaa/Projects/internhub/tests/Unit/RequestTest.php)
- [RouterTest.php](/Users/abdoufrigaa/Projects/internhub/tests/Unit/RouterTest.php)
- [AuthAndMiddlewareTest.php](/Users/abdoufrigaa/Projects/internhub/tests/Unit/AuthAndMiddlewareTest.php)

Hygiene repo :

- [.gitignore](/Users/abdoufrigaa/Projects/internhub/.gitignore) ignore maintenant `vendor/`, `.phpunit.cache/` et l outillage local `tools/composer.phar`.

## 2. Choix de mise en oeuvre

Contrainte constatee :

- aucun `composer` global n etait disponible sur la machine.

Decision prise :

- ajout d un `composer.json` standard au repo,
- usage d un `Composer` local dans `tools/composer.phar`,
- installation de `PHPUnit` via dependance `require-dev`,
- conservation des smoke tests HTTP existants comme filet d integration.

Ce choix donne un socle reproductible sans dependre d un outillage global preinstalle.

## 3. Perimetre couvert par les premiers tests

Le premier lot cible les unites les plus stables et les moins couplees :

- configuration imbriquee,
- normalisation et lecture de requete,
- dispatch du routeur et resolution des params,
- comportements d authentification et de middleware de role.

Lecture :

- ce n est pas encore une couverture metier profonde,
- c est la bonne base pour commencer `P8` sans destabiliser les modules deja verifies par smoke tests.

## 4. Commandes de verification

Commande unitaire directe :

- `./vendor/bin/phpunit`

Commande standard projet :

- `php tools/composer.phar test`

Resultat obtenu :

- `12 tests`
- `31 assertions`
- suite verte sans deprecations.

## 5. Positionnement dans la phase

Cette etape ne remplace pas les smoke tests `P6` et `P7`.

Le socle final de verification devient :

- tests unitaires pour les briques coeur,
- smoke tests HTTP pour les parcours applicatifs.

## 6. Prochaine action

Passer a `P8.5 Responsive, accessibilite pratique et performance legere`, ou etendre ce socle unitaire aux validations metier introduites dans `P8.1` et `P8.2`.
