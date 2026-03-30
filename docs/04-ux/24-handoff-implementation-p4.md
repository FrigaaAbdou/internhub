# Handoff P4 vers implementation

Ce document formalise le `Lot 10 - Handoff vers implementation` de la phase `P4. UX et interfaces`.

Il transforme les artefacts UX produits pendant `P4` en consignes d'execution utilisables par l'equipe de developpement.

L'objectif est simple :
permettre a un developpeur d'implementer les vues MVP sans reinventer la navigation, les etats, les composants, les retours utilisateur ou les contraintes d'accessibilite.

## 1. Sources de reference a remettre au dev

Le handoff `P4` repose sur les documents suivants :

- [13-validation-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/13-validation-mvp.md)
- [14-plan-implementation-p4-ux-interfaces.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/14-plan-implementation-p4-ux-interfaces.md)
- [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md)
- [16-navigation-et-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/16-navigation-et-parcours.md)
- [17-wireframes-prioritaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/17-wireframes-prioritaires.md)
- [18-wireframes-structurels-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/18-wireframes-structurels-mvp.md)
- [19-systeme-composants-ui.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/19-systeme-composants-ui.md)
- [20-matrice-etats-formulaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/20-matrice-etats-formulaires.md)
- [21-spec-responsive-mobile-first.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/21-spec-responsive-mobile-first.md)
- [22-accessibilite-integree.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/22-accessibilite-integree.md)
- [23-prototype-validation-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/23-prototype-validation-parcours.md)
- [06-architecture-mvc.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/06-architecture-mvc.md)

Regle de priorite :

1. matrice de permissions,
2. MVP valide,
3. navigation et parcours,
4. wireframes et systeme de composants,
5. details visuels et de prototype.

Si deux documents se contredisent, la regle de priorite ci-dessus s'applique.

## 2. Ce que le developpement recupere concretement

Le handoff doit etre compris comme un paquet d'instructions operables :

- un catalogue de vues a construire,
- un schema de navigation par role,
- une priorisation de production des ecrans,
- une specification structurelle de chaque ecran MVP,
- un systeme de composants reutilisables,
- une matrice des etats, messages et erreurs,
- des regles responsive mobile first,
- une base de contraintes accessibilite,
- un protocole de validation de parcours.

Le developpement ne doit pas reconsiderer ces points a zero. Il doit les implementer, signaler les ecarts, puis corriger si necessaire.

## 3. Vues MVP a implementer

Les ecrans MVP a prendre en charge en premier sont :

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

Le developpement doit traiter ces vues comme perimetre cible minimal avant tout enrichissement visuel ou fonctionnel hors MVP.

## 4. Ordre recommande d'implementation

Pour limiter les blocages, l'ordre recommande est le suivant.

### Lot dev A - Socle technique et shells

- bootstrap MVC
- routeur
- gestion des sessions
- authentification
- protection `CSRF`
- layouts publics et proteges
- pages `403`, `404`, `500`

Resultat attendu :
une application navigable avec routing, login, logout, guards et rendu des layouts communs.

### Lot dev B - Consultation publique

- accueil
- liste des offres
- detail offre
- liste des entreprises
- detail entreprise
- pagination

Resultat attendu :
un visiteur peut consulter les contenus publics sans connexion.

### Lot dev C - Parcours etudiant

- acces etudiant apres login
- formulaire de candidature
- validation serveur et client
- upload de CV
- prevention du doublon de candidature
- liste des candidatures etudiant

Resultat attendu :
le parcours `consultation -> postuler -> suivi` fonctionne de bout en bout.

### Lot dev D - Parcours pilote

- dashboard pilote
- liste des etudiants de la promotion
- consultation des candidatures d'un etudiant
- creation de compte etudiant

Resultat attendu :
le pilote peut superviser sa promotion et creer un compte etudiant dans son perimetre.

### Lot dev E - Ajustements de soutenance

- polissage visuel raisonnable
- messages systeme finals
- corrections responsive et accessibilite
- correction des anomalies restantes issues de `Lot 9`

Resultat attendu :
une version defendable, stable et demonstrable.

## 5. Mapping des artefacts UX vers le code

Le tableau ci-dessous indique comment exploiter les livrables `P4` pendant l'implementation.

| Artefact | Usage developpement | Impact concret |
| --- | --- | --- |
| [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md) | liste de reference des vues et routes | creation du registre de routes, des controleurs et des vues |
| [16-navigation-et-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/16-navigation-et-parcours.md) | comportement des redirections et retours | logique post-login, guard `login/403`, liens retour |
| [17-wireframes-prioritaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/17-wireframes-prioritaires.md) | ordre de travail | priorisation du backlog front et integration |
| [18-wireframes-structurels-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/18-wireframes-structurels-mvp.md) | structure de chaque page | blocs a rendre dans chaque template |
| [19-systeme-composants-ui.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/19-systeme-composants-ui.md) | base de composants communs | partials, classes CSS, conventions de variantes |
| [20-matrice-etats-formulaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/20-matrice-etats-formulaires.md) | comportements de page et feedback | messages flash, erreurs de validation, etats vides |
| [21-spec-responsive-mobile-first.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/21-spec-responsive-mobile-first.md) | responsive | breakpoints, empilement mobile, tables et filtres |
| [22-accessibilite-integree.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/22-accessibilite-integree.md) | accessibilite | labels, focus, contraste, structure HTML |
| [23-prototype-validation-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/23-prototype-validation-parcours.md) | validation finale | scripts de test manuels par role |

## 6. Contraintes non negociables cote implementation

Le passage au code ne doit pas affaiblir les regles suivantes :

- respect strict de la `Matrice_permissions_2025_V2_1.json`,
- verification des permissions cote serveur, pas seulement dans l'UI,
- acces `SQL` via `PHP PDO` et requetes preparees,
- protection `CSRF` sur tous les formulaires sensibles,
- validation serveur pour login, candidature et creation de compte etudiant,
- rendu exploitable sur mobile et desktop,
- presence des pages `403`, `404`, `500`,
- absence d'action interdite affichee pour un role non autorise,
- messages de succes et d'erreur compréhensibles,
- structure HTML compatible avec les exigences d'accessibilite deja definies.

## 7. Structure technique minimale attendue

L'implementation doit rester compatible avec [06-architecture-mvc.md](/Users/abdoufrigaa/Projects/internhub/docs/02-architecture/06-architecture-mvc.md).

Structure minimale attendue :

- `public/index.php`
- `config/`
- `app/Core/`
- `app/Controllers/`
- `app/Models/`
- `app/Views/`
- `storage/`
- `tests/`

Elements a preparer en premier :

- routeur central,
- classe `Request`,
- classe `Response`,
- classe `Controller`,
- rendu de vues avec layout,
- gestion de session,
- couche d'authentification,
- connexion `PDO`,
- gestion centralisee des erreurs minimales.

## 8. Liste des composants et vues a mutualiser

Pour limiter les regressions visuelles et accelerer le dev, les elements suivants doivent etre mutualises des le debut :

- header public,
- header authentifie,
- navigation rolee,
- footer,
- conteneur de message flash,
- champ texte,
- champ email,
- champ mot de passe,
- `select`,
- `textarea`,
- upload fichier,
- bouton primaire,
- bouton secondaire,
- bouton danger si utilise,
- carte offre,
- carte entreprise,
- tableau simple,
- badge de statut,
- etat vide,
- pagination.

## 9. Donnees de demonstration a prevoir pendant l'integration

Le developpement doit disposer de donnees minimales coherentes avec le prototype :

- plusieurs offres avec cas nominal et cas deja candidate,
- plusieurs entreprises avec et sans offres,
- au moins un etudiant rattache a une promotion,
- au moins un pilote rattache a cette promotion,
- au moins un administrateur,
- un historique minimal de candidatures,
- un jeu d'erreurs pour `403`, `404`, `500`.

Ces donnees doivent permettre de rejouer les parcours du document [23-prototype-validation-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/23-prototype-validation-parcours.md).

## 10. Decisions ouvertes residuelles

Les points suivants doivent etre surveilles pendant le passage en implementation :

- stabilisation finale du schema officiel de routes si l'equipe veut harmoniser francais et anglais,
- statut definitif de `/register`, qui reste hors MVP et contradictoire avec la creation geree des comptes etudiants,
- choix final entre `/dashboard/admin` et le fallback `/admin/comptes` selon le temps reel disponible,
- normalisation finale des noms d'ecrans et d'URLs avant soutenance.

Regle :
si une de ces decisions change, les documents `15` a `23` potentiellement touches doivent etre mis a jour avant la fin du dev.

## 11. Controle qualite avant gel implementation

Avant de considerer le handoff `P4` comme correctement absorbe par le dev, l'equipe doit verifier :

- que chaque vue MVP dispose d'une route, d'un controleur et d'un template identifies,
- que chaque formulaire critique a ses validations et erreurs connues,
- que chaque garde de role est implemente cote serveur,
- que les layouts publics et proteges sont partages,
- que les composants communs ne sont pas reimplementes plusieurs fois,
- que les ecrans d'erreur existent reellement,
- que les parcours critiques peuvent etre testes avec des donnees de demonstration.

## 12. Definition of Done du handoff

Le `Lot 10 - Handoff vers implementation` est termine seulement si :

- les artefacts `P4` sont complets, indexes et exploitables,
- l'ordre d'implementation du MVP est fige,
- les contraintes techniques et UX non negociables sont explicites,
- les decisions encore ouvertes sont isolees,
- un developpeur peut commencer le code sans deviner la logique UX attendue.

## 13. Recommandation immediate

La suite logique n'est plus de produire d'autres documents UX.

La suite logique est :

1. initialiser la structure MVC,
2. enregistrer les routes MVP,
3. poser les layouts et composants partages,
4. implementer `login`, `offres`, `entreprises`, `candidature`,
5. terminer par le parcours pilote et les pages systeme.
