# Prototype et validation des parcours

Ce document formalise le `Lot 9 - Prototype et validation des parcours` de la phase `P4. UX et interfaces`.

L'objectif n'est pas de produire un prototype "joli". L'objectif est de verifier, avant implementation, que les parcours critiques du MVP sont faisables, coherents, conformes a la matrice de permissions et exempts d'impasse UX evidente.

## 1. Sources de reference

- [13-validation-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/13-validation-mvp.md)
- [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md)
- [16-navigation-et-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/16-navigation-et-parcours.md)
- [18-wireframes-structurels-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/18-wireframes-structurels-mvp.md)
- [19-systeme-composants-ui.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/19-systeme-composants-ui.md)
- [20-matrice-etats-formulaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/20-matrice-etats-formulaires.md)
- [21-spec-responsive-mobile-first.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/21-spec-responsive-mobile-first.md)
- [22-accessibilite-integree.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/22-accessibilite-integree.md)

Regle de priorite :
si un prototype contredit la `Matrice_permissions_2025_V2_1.json`, c'est le prototype qui doit etre corrige.

## 2. Objectif de validation

Le prototype doit permettre de confirmer les points suivants avant implementation :

- chaque role atteint ses objectifs MVP sans detour inutile,
- aucun ecran ne promet une action interdite,
- aucune etape critique ne provoque de confusion sur le prochain pas,
- les retours apres action sont explicites et utiles,
- les etats d'erreur et d'acces refuse restent compréhensibles,
- les parcours tiennent en mobile et desktop sans rupture fonctionnelle.

## 3. Nature du prototype attendu

Le livrable attendu pour `Lot 9` est un prototype cliquable ou un equivalent navigable de fidelite fonctionnelle suffisante.

Le prototype doit au minimum couvrir :

- les transitions entre ecrans MVP,
- les CTA principaux,
- les retours vers les listes et dashboards,
- les etats vides, succes, erreur et acces refuse des parcours critiques,
- les differences de navigation entre `Anonyme`, `Etudiant`, `Pilote` et `Administrateur`.

Le prototype n'a pas besoin de simuler :

- un moteur de recherche reel,
- un backend temps reel,
- des calculs statistiques complets,
- les ecrans hors MVP valides comme `P2+`.

## 4. Regles de construction du prototype

- chaque ecran prototype doit reprendre un identifiant de vue du catalogue quand il existe,
- chaque lien ou CTA doit conduire a un ecran utile, jamais a une impasse,
- chaque action critique doit montrer un resultat de succes ou d'erreur,
- les actions interdites ne doivent pas etre visibles dans les variantes de role non autorisees,
- les retours de navigation doivent rester coherents avec [16-navigation-et-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/16-navigation-et-parcours.md),
- les variantes mobile et desktop doivent etre au moins testees sur les ecrans critiques,
- les ecrans `403`, `404` et `500` doivent etre navigables dans le prototype.

## 5. Jeux de donnees de demonstration a simuler

Pour que la validation soit credible, le prototype doit s'appuyer sur un jeu de donnees minimal coherent.

Jeu minimum recommande :

- 6 offres dont au moins 1 deja expiree et 1 deja candidatee par l'etudiant,
- 4 entreprises dont au moins 1 sans offre active,
- 1 etudiant avec 2 candidatures existantes,
- 1 etudiant sans candidature,
- 1 pilote avec une promotion contenant au moins 5 etudiants,
- 1 administrateur avec acces a la gestion des comptes,
- 1 cas d'erreur metier : candidature deja envoyee,
- 1 cas d'erreur technique : echec de soumission,
- 1 cas `403`,
- 1 cas `404`.

## 6. Parcours a prototyper et valider

## 6.1 Parcours visiteur

Objectif :
confirmer qu'un visiteur comprend le produit, consulte les offres et comprend qu'une authentification est necessaire pour agir.

Script nominal :

1. ouvrir l'accueil `V-PUB-001`
2. ouvrir la liste des offres `V-PUB-005`
3. filtrer ou parcourir la liste
4. ouvrir le detail d'une offre `V-PUB-006`
5. cliquer sur `Postuler`
6. verifier la redirection vers `login`

Points a verifier :

- les CTA publics sont visibles sans surcharge,
- la transition `detail offre -> login` est explicite,
- le visiteur comprend pourquoi l'action est protegee,
- le retour vers les offres reste facile apres connexion.

## 6.2 Parcours etudiant

Objectif :
confirmer qu'un etudiant peut se connecter, consulter une offre, postuler et retrouver sa candidature sans friction.

Script nominal MVP :

1. ouvrir `login`
2. soumettre des identifiants valides
3. verifier la redirection vers `/offres` en fallback MVP
4. ouvrir une offre depuis la liste
5. lancer la candidature
6. soumettre une candidature valide
7. verifier le succes
8. ouvrir `Mes candidatures`
9. retrouver la candidature envoyee

Scripts complementaires obligatoires :

1. erreur d'authentification
2. formulaire de candidature invalide
3. fichier refuse
4. candidature deja envoyee
5. tentative d'acces a une page `Pilote` puis affichage `403`

Points a verifier :

- le parcours n'impose pas de dashboard etudiant non MVP,
- le formulaire de candidature reste clair sur mobile,
- le succes de soumission oriente vers la suite utile,
- la liste des candidatures permet de confirmer l'action precedente.

## 6.3 Parcours pilote

Objectif :
confirmer qu'un pilote peut superviser sa promotion et creer un compte etudiant sans ambiguite.

Script nominal supervision :

1. ouvrir `login`
2. soumettre des identifiants pilote valides
3. verifier l'arrivee sur `/dashboard/pilote`
4. ouvrir la liste des etudiants
5. ouvrir les candidatures d'un etudiant
6. revenir a la liste ou au dashboard sans perdre le contexte

Script nominal creation de compte etudiant :

1. ouvrir `Creer un compte etudiant`
2. remplir le formulaire avec des donnees valides
3. soumettre
4. verifier le message de succes
5. verifier le retour vers la liste des etudiants ou un ecran coherent

Scripts complementaires obligatoires :

1. email deja utilise
2. formulaire incomplet
3. tentative d'action etudiante interdite puis `403`
4. acces a un etudiant hors perimetre si ce cas existe dans le prototype

Points a verifier :

- le pilote voit clairement ses actions de supervision,
- la creation de compte etudiant est identifiee comme action distincte,
- le retour apres creation ne cree pas d'incertitude,
- les actions de pilotage ne se confondent pas avec des actions d'administration globale.

## 6.4 Parcours administrateur

Objectif :
confirmer qu'un administrateur atteint rapidement une vue de gestion conforme au MVP retenu.

Script nominal :

1. ouvrir `login`
2. soumettre des identifiants administrateur valides
3. verifier la redirection vers `/dashboard/admin` ou le fallback `/admin/comptes`
4. ouvrir la gestion minimale des comptes etudiants
5. verifier la lisibilite des actions de gestion disponibles

Scripts complementaires obligatoires :

1. acces a une vue `Pilote` reservee puis `403`
2. retour vers la vue de gestion principale

Points a verifier :

- l'administrateur n'atterrit pas sur une page publique sans contexte,
- la navigation de gestion est explicite,
- les droits admin ne sont pas simules au-dela du perimetre reellement valide.

## 6.5 Parcours systeme

Les ecrans suivants doivent etre testes comme parcours a part entiere :

- `403` acces refuse
- `404` ressource introuvable
- `500` erreur technique

Points a verifier :

- le message explique la situation sans jargon inutile,
- un CTA principal permet de sortir proprement de l'erreur,
- le contexte ne fait pas croire a une perte de donnees non confirmee.

## 7. Protocole de validation

## 7.1 Format de revue

Chaque parcours critique doit etre valide au moins par :

- 1 passe de revue fonctionnelle,
- 1 passe de revue UX,
- 1 passe de revue implementation faisabilite.

Si l'equipe est reduite, une meme personne peut porter plusieurs angles, mais les trois angles doivent etre traites explicitement.

## 7.2 Questions de controle

Pour chaque etape d'un parcours, il faut verifier :

- ou suis-je ?
- que puis-je faire ici ?
- quelle est l'action principale ?
- que se passe-t-il apres cette action ?
- puis-je revenir sans me perdre ?
- que se passe-t-il si je n'ai pas le droit ou si la donnee manque ?

## 7.3 Grille d'observation minimale

Pour chaque parcours teste, relever :

- point d'entree,
- sequence d'ecrans,
- action realisee,
- resultat attendu,
- resultat observe dans le prototype,
- ecart constate,
- severite,
- decision de correction.

## 8. Classification des anomalies

### Bloquante

Une anomalie est bloquante si :

- le parcours ne peut pas aller jusqu'au bout,
- un role atteint une action interdite par la matrice,
- une action critique ne fournit aucun retour comprehensible,
- le prototype cree une impasse sans retour exploitable.

### Majeure

Une anomalie est majeure si :

- l'utilisateur peut finir mais avec forte confusion,
- le prochain pas n'est pas evident,
- le retour apres succes ou erreur est mauvais,
- la mobile UX empeche raisonnablement l'usage.

### Mineure

Une anomalie est mineure si :

- le probleme n'empeche pas la comprehension generale,
- il s'agit surtout d'un probleme de libelle, de hierarchie ou d'alignement visuel secondaire.

Regle de sortie :

- zero anomalie bloquante,
- zero anomalie majeure sur les parcours critiques MVP,
- anomalies mineures listees et arbitrees avant handoff.

## 9. Decisions a figer a la fin de Lot 9

A la fin de la validation des parcours, les points suivants doivent etre geles :

- redirections finales apres login par role,
- point de sortie apres candidature et apres creation de compte etudiant,
- CTA principal et CTA secondaire de chaque ecran critique,
- comportement exact des ecrans `403`, `404` et `500`,
- retours liste/detail/action,
- messages fonctionnels critiques.

Tout point non fige doit etre consigne comme decision ouverte avant passage au handoff.

## 10. Livrables obligatoires

Le `Lot 9` est considere comme correctement execute si l'equipe produit :

- un prototype cliquable ou equivalent navigable,
- une grille de validation remplie pour chaque role,
- une liste d'anomalies avec severite,
- une liste de corrections appliquees,
- une liste residuelle de decisions ouvertes si elles existent encore.

## 11. Definition of Done

Le `Lot 9 - Prototype et validation des parcours` est termine seulement si :

- les parcours `Visiteur`, `Etudiant`, `Pilote` et `Administrateur` ont ete joues de bout en bout,
- les parcours systeme `403`, `404` et `500` ont ete verifies,
- les retours apres succes et erreur sont documentes,
- les issues de permissions ont ete comparees a la matrice officielle,
- aucune impasse UX critique ne subsiste,
- les anomalies bloquantes et majeures ont ete corrigees ou arbitrees,
- les decisions de navigation encore ouvertes ont ete isolees avant le handoff final.

## 12. Recommandation de travail

Pour garder un niveau defendable en soutenance et exploitable en implementation :

1. prototyper d'abord les parcours MVP, pas les ecrans secondaires,
2. tester ensuite les erreurs et acces refuses,
3. faire la revue mobile avant de geler les parcours,
4. seulement ensuite preparer le handoff final du `Lot 10`.
