# InternHub

Application `PHP MVC` de gestion d offres, candidatures, suivi pilote et administration de comptes.

Le projet est structure pour une demonstration de soutenance :

- consultation publique des offres, entreprises et statistiques,
- espace `etudiant`,
- espace `pilote`,
- espace `administrateur`,
- verification rejouable par tests unitaires et smoke tests.

## Demarrage rapide

Prerequis :

- `PHP 8.5`
- `Composer`
- `sqlite3`

Initialisation locale recommandee pour la demo :

1. `cp .env.sqlite.example .env`
2. `composer install`
3. `bash scripts/reset-demo-state.sh`
4. `php -S 127.0.0.1:8000 -t public`

Application disponible ensuite sur :

- [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Comptes de demonstration

- `student@internhub.test` / `Student123!`
- `pilot@internhub.test` / `Pilot123!`
- `admin@internhub.test` / `Admin123!`

## Verification

Tests unitaires :

- `./vendor/bin/phpunit`

Verification complete de stabilisation :

- `bash tests/smoke/p8_http_smoke.sh`

Reset du contexte de demo :

- `bash scripts/reset-demo-state.sh`

## Documentation

Point d entree documentaire :

- [docs/README.md](/Users/abdoufrigaa/Projects/internhub/docs/README.md)

Documents les plus utiles pour une livraison ou une soutenance :

- [docs/03-execution/24-script-demo-p9.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/24-script-demo-p9.md)
- [docs/03-execution/25-jeu-donnees-comptes-demo-p9.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/25-jeu-donnees-comptes-demo-p9.md)
- [docs/03-execution/22-verification-phase-p8.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/22-verification-phase-p8.md)
- [tests/README.md](/Users/abdoufrigaa/Projects/internhub/tests/README.md)
