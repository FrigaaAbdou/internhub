# P8.5 Responsive, accessibilite pratique et performance legere

Ce document formalise le travail de `P8.5`.

L objectif de ce lot n etait pas de faire une recette graphique exhaustive ni un benchmark de charge, mais de verifier que les parcours critiques restent lisibles, accessibles et rapides dans le contexte reel du projet.

## 1. Perimetre controle

Pages et familles de pages revues :

- accueil,
- login,
- liste des offres,
- liste des entreprises,
- dashboards `etudiant`, `pilote`, `administrateur`,
- gestion `comptes`, `entreprises`, `offres`,
- tableaux `candidatures` et `wish-list`.

## 2. Verifications realisees

### Relecture pratique du front

Verification du shell HTML et du CSS partage :

- meta viewport presente,
- boutons et zones tactiles deja calibres a `44px` ou plus,
- breakpoint mobile principal deja en place,
- focus visibles deja definis sur les actions principales,
- messages flash annonces avec `role=\"status\"` et `role=\"alert\"`.

### Passage runtime

Verification HTTP locale sur les pages critiques :

- routes publiques `offres` et `entreprises`,
- connexion administrateur,
- pages `/admin/comptes`, `/admin/entreprises`, `/admin/offres`.

Resultat :

- aucune erreur PHP sur les vues modifiees,
- rendu HTTP correct sur les pages revues,
- non-regression unitaire confirmee par `PHPUnit`.

### Mesures legeres de performance

Mesures effectuees en local, avec :

- serveur PHP embarque,
- SQLite local,
- jeu de donnees de demonstration.

Ces chiffres ne sont pas des engagements de production. Ils servent seulement a detecter une faiblesse evidente.

Routes publiques :

- `/` : `ttfb 15.5 ms`, `total 15.7 ms`
- `/login` : `ttfb 1.9 ms`, `total 2.0 ms`
- `/offres` : `ttfb 3.9 ms`, `total 4.0 ms`
- `/offres/1` : `ttfb 1.5 ms`, `total 1.6 ms`
- `/entreprises` : `ttfb 1.7 ms`, `total 1.8 ms`
- `/statistiques` : `ttfb 2.0 ms`, `total 2.1 ms`

Routes authentifiees :

- `/dashboard/etudiant` : `ttfb 3.4 ms`, `total 3.5 ms`
- `/dashboard/etudiant/wishlist` : `ttfb 1.6 ms`, `total 1.6 ms`
- `/dashboard/pilote` : `ttfb 1.9 ms`, `total 2.0 ms`
- `/dashboard/pilote/etudiants` : `ttfb 1.3 ms`, `total 1.4 ms`
- `/dashboard/admin` : `ttfb 2.3 ms`, `total 2.4 ms`
- `/admin/comptes` : `ttfb 1.6 ms`, `total 1.7 ms`

Conclusion :

- aucune page critique ne montre de lenteur evidente dans le contexte local du projet,
- le point faible de ce lot etait bien l ergonomie mobile des tableaux, pas la performance brute.

## 3. Corrections appliquees

Les corrections de ce lot ont ete implementees directement dans le code.

### Accessibilite pratique

- ajout d un lien d echappement vers le contenu principal,
- ajout d un identifiant de cible sur `<main>`,
- ajout de labels accessibles sur les formulaires de recherche qui reposaient encore sur le placeholder,
- ajout de `aria-current=\"page\"` sur les paginations actives.

### Responsive en pratique

- ajout d une utility `sr-only`,
- ajout d un pattern mobile pour les tableaux avec `data-label`,
- adaptation des actions de tableau pour eviter des blocs illisibles sur petit ecran.

### Experience de repli

- ajout d etats vides explicites pour :
  - la gestion des comptes,
  - la liste des etudiants cote pilote,
  - la gestion des entreprises,
  - la gestion des offres.

## 4. Resultat du lot

`P8.5` peut etre considere comme valide sur son perimetre :

- les pages critiques restent lisibles en mobile-first simple,
- les tableaux principaux ne reposent plus sur des en-tetes invisibles en petit ecran,
- les formulaires de recherche critiques ont un libelle accessible,
- les pages de gestion ont maintenant un repli propre quand elles sont vides,
- aucune faiblesse evidente de performance n a ete observee en local.

## 5. Limites residuelles

Ce lot ne clot pas toute la finition front :

- un seul breakpoint principal est encore utilise,
- il n y a pas de tests visuels automatises,
- les meta `title` restent statiques dans le layout,
- les mentions legales et la finition SEO ne sont pas encore traitees.

Ces points relevent de `P8.6`.

## 6. Verification utilisee

Commandes executees pour ce lot :

- `php -l` sur les vues modifiees,
- `./vendor/bin/phpunit`,
- verification HTTP locale des routes publiques et des gestions admin,
- mesures `curl` sur les pages critiques.

## 7. Prochaine action

Passer a `P8.6 Mentions legales, meta et hygiene finale`.
