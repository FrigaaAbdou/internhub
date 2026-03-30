# Wireframes prioritaires

Ce document formalise le `Lot 3 - Priorisation des ecrans a concevoir` de la phase `P4`.

Il transforme l'inventaire des vues et les parcours de navigation en ordre de production concret pour les wireframes.

## 1. Objectif

Definir dans quel ordre les ecrans doivent etre maquettés afin de :

- couvrir d'abord les parcours MVP,
- eviter les dependances bloquantes tardives,
- produire des wireframes directement exploitables par l'equipe de dev,
- garantir que les ecrans critiques existent avant les variantes secondaires.

## 2. Regles de priorisation

Un ecran est prioritaire s'il remplit un ou plusieurs de ces criteres :

- il appartient a un parcours MVP,
- il debloque plusieurs autres ecrans,
- il porte une action metier critique,
- il expose un risque UX ou technique eleve,
- il sert de reference structurelle pour plusieurs composants communs,
- il permet de verifier les permissions et redirections par role.

## 3. Niveaux de priorite retenus

- `W0` : ecran fondation, a produire en tout premier
- `W1` : ecran coeur MVP, indispensable pour les parcours critiques
- `W2` : ecran MVP de soutien, necessaire pour completer les parcours
- `W3` : ecran hors MVP ou enrichissement post-MVP

## 4. Vagues de production recommandees

### Vague 0 - Fondation

But :
poser les patterns de layout, de navigation, de formulaire et de feedback.

Ecrans :

- `V-PUB-001` accueil
- `V-PUB-004` login
- `V-SYS-001` `403`
- `V-SYS-002` `404`
- `V-SYS-003` `500`

Pourquoi commencer ici :

- l'accueil pose la structure publique,
- le login pose les formulaires critiques,
- les pages d'erreur posent les garde-fous de navigation.

Critere de sortie :

- header public stable,
- footer minimal stable,
- pattern de formulaire stable,
- pattern de messages d'erreur stable.

### Vague 1 - Coeur de consultation

But :
poser les ecrans qui servent de base a tous les roles.

Ecrans :

- `V-PUB-005` liste des offres
- `V-PUB-006` detail offre
- `V-PUB-007` liste des entreprises
- `V-PUB-008` detail entreprise

Pourquoi maintenant :

- ces ecrans sont partages par tous les roles,
- ils etablissent les patterns de liste, detail, filtre et pagination,
- ils conditionnent le parcours de candidature.

Critere de sortie :

- pattern de liste stable,
- pattern de detail stable,
- zones de filtre et de pagination documentees,
- comportement des CTA selon le role explicite.

### Vague 2 - Parcours etudiant coeur

But :
securiser le coeur metier etudiant.

Ecrans :

- `V-ETU-004` candidature
- `V-ETU-005` liste des candidatures etudiant

Pourquoi maintenant :

- ces vues demontrent la valeur principale du produit,
- elles introduisent les contraintes les plus sensibles : formulaire, upload, validation, etat de succes, doublon.

Critere de sortie :

- formulaire candidature complet,
- etats d'erreur et succes documentes,
- parcours apres soumission stabilise,
- retour vers detail offre et liste candidatures stabilise.

### Vague 3 - Parcours pilote coeur

But :
rendre visible la difference de role et la supervision pedagogique.

Ecrans :

- `V-PIL-001` dashboard pilote
- `V-PIL-002` liste des etudiants pilote
- `V-PIL-004` candidatures d'un etudiant cote pilote
- `V-PIL-006` creation de compte etudiant

Pourquoi maintenant :

- ces vues couvrent `SFx16`, `SFx17` et `SFx22`,
- elles justifient la presence du role `Pilote` dans le produit,
- elles introduisent les cas de controle par promotion.

Critere de sortie :

- navigation pilote stable,
- pattern de tableau ou liste etudiant stable,
- pattern de creation de compte etudiant stable,
- etats d'acces refuse et perimetre promo documentes.

### Vague 4 - Ecrans de soutien MVP

But :
combler les trous qui empecheraient une demonstration propre.

Ecrans :

- vues de confirmation ou d'etat de soumission si elles existent comme ecrans dedies,
- variantes mobiles critiques des ecrans MVP,
- vues de detail candidature si elles deviennent necessaires a la demo.

Critere de sortie :

- aucune impasse dans les parcours MVP,
- aucune transition critique non documentee.

### Vague 5 - Hors MVP et enrichissements

But :
preparer les evolutions apres stabilisation du coeur.

Ecrans :

- `V-ETU-001` dashboard etudiant
- `V-ETU-002` profil
- `V-ETU-003` edition profil
- `V-ETU-006` detail candidature
- `V-ETU-007` telechargement CV
- `V-ETU-008` wishlist
- `V-ADM-001` a `V-ADM-011`
- `V-PUB-002` landing
- `V-PUB-003` about
- `V-PUB-009` register si confirme
- `V-PIL-003` fiche etudiant pilote
- `V-PIL-005` telechargement document pilote

## 5. Backlog priorise des wireframes

| Ordre | ID vue | Priorite | Raison principale | Dependances avant maquettage |
| --- | --- | --- | --- | --- |
| 1 | `V-PUB-004` | W0 | point d'entree auth, redirections, erreurs | pattern formulaire public |
| 2 | `V-PUB-005` | W1 | base du parcours public et etudiant | filtres, pagination, cartes ou tableau |
| 3 | `V-PUB-006` | W1 | pivot avant candidature | CTA contextuels par role |
| 4 | `V-ETU-004` | W1 | coeur metier de candidature | login, detail offre, upload, validation |
| 5 | `V-ETU-005` | W1 | suivi etudiant apres action | pattern liste + statuts |
| 6 | `V-PUB-007` | W1 | deuxieme porte d'entree publique | pattern liste |
| 7 | `V-PUB-008` | W1 | articulation entreprise -> offre | pattern detail |
| 8 | `V-PIL-001` | W2 | hub pilote | navigation pilote |
| 9 | `V-PIL-002` | W2 | gestion etudiants promo | tableau, filtres simples |
| 10 | `V-PIL-004` | W2 | suivi candidatures promo | pattern liste + pieces jointes |
| 11 | `V-PIL-006` | W2 | creation compte etudiant | pattern formulaire admin/pilote |
| 12 | `V-PUB-001` | W2 | structure publique et orientation | CTA principaux |
| 13 | `V-SYS-001` | W2 | acces refuse | pattern erreurs |
| 14 | `V-SYS-002` | W2 | ressource introuvable | pattern erreurs |
| 15 | `V-SYS-003` | W2 | erreur serveur | pattern erreurs |
| 16 | `V-ETU-001` | W3 | enrichissement post-MVP | navigation etudiant |
| 17 | `V-ETU-002` | W3 | enrichissement post-MVP | arbitrage profil |
| 18 | `V-ETU-003` | W3 | enrichissement post-MVP | arbitrage profil edit |
| 19 | `V-ETU-006` | W3 | detail secondaire | besoin produit a confirmer |
| 20 | `V-ETU-007` | W3 | telechargement document | stockage fichier |
| 21 | `V-ETU-008` | W3 | wishlist hors MVP | wish-list |
| 22 | `V-PIL-003` | W3 | detail etudiant hors MVP | controle promo detaille |
| 23 | `V-PIL-005` | W3 | document pilote hors MVP | stockage fichier |
| 24 | `V-ADM-001` | W3 | admin hors MVP | navigation admin |
| 25 | `V-ADM-002` | W3 | admin hors MVP | gestion comptes |
| 26 | `V-ADM-003` | W3 | admin hors MVP | formulaire comptes |
| 27 | `V-ADM-004` | W3 | admin hors MVP | edition comptes |
| 28 | `V-ADM-005` | W3 | admin hors MVP | gestion entreprises |
| 29 | `V-ADM-006` | W3 | admin hors MVP | creation entreprise |
| 30 | `V-ADM-007` | W3 | admin hors MVP | edition entreprise |
| 31 | `V-ADM-008` | W3 | admin hors MVP | gestion offres |
| 32 | `V-ADM-009` | W3 | admin hors MVP | creation offre |
| 33 | `V-ADM-010` | W3 | admin hors MVP | edition offre |
| 34 | `V-ADM-011` | W3 | admin hors MVP | statistiques |
| 35 | `V-PUB-002` | W3 | contenu marketing | contenu editorial |
| 36 | `V-PUB-003` | W3 | contenu institutionnel | contenu editorial |
| 37 | `V-PUB-009` | W3 | route non stabilisee | arbitrage `/register` |

## 6. Profondeur attendue par wireframe

### W0

Niveau exige :

- structure complete,
- hierarchy visuelle fonctionnelle,
- etats d'erreur minimum,
- zones de navigation stabilisees,
- composants nominaux deja identifies.

### W1

Niveau exige :

- layout complet,
- donnees affichees explicites,
- CTA principal et secondaires,
- etats vides, erreurs et succes documentes,
- responsive de premier niveau deja reflechi,
- permissions visibles dans les actions.

### W2

Niveau exige :

- meme niveau que W1,
- plus regles de navigation inter-ecrans,
- plus cas d'usage role-specifiques.

### W3

Niveau exige :

- production seulement apres stabilisation des W0 a W2,
- peut commencer en basse fidelite fonctionnelle.

## 7. Paquets de travail recommandes

Pour eviter les allers-retours inutiles, je recommande ces paquets :

### Pack A - Fondation publique

- `V-PUB-004`
- `V-PUB-001`
- `V-SYS-001`
- `V-SYS-002`
- `V-SYS-003`

### Pack B - Consultation

- `V-PUB-005`
- `V-PUB-006`
- `V-PUB-007`
- `V-PUB-008`

### Pack C - Candidature etudiant

- `V-ETU-004`
- `V-ETU-005`

### Pack D - Supervision pilote

- `V-PIL-001`
- `V-PIL-002`
- `V-PIL-004`
- `V-PIL-006`

## 8. Garde-fous de production-ready

- ne pas commencer les ecrans admin hors MVP avant d'avoir fige tous les ecrans W1,
- ne pas lancer un wireframe de detail avant que le wireframe de liste correspondant soit stable,
- ne pas concevoir la candidature sans la liste et le detail d'offre,
- ne pas concevoir la liste des candidatures pilote sans le pattern de liste etudiant,
- ne pas lancer de variation visuelle avant la validation structurelle,
- ne pas traiter les ecrans d'erreur comme secondaires.

## 9. Definition of Done du Lot 3

Le `Lot 3` est termine si :

- l'ordre de production est valide,
- chaque ecran prioritaire a un niveau de priorite explicite,
- les dependances de maquettage sont identifiees,
- les ecrans hors MVP sont clairement separes,
- l'equipe peut demarrer le `Lot 4` sans ambiguite sur l'ordre de conception.
