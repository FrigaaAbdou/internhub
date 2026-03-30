# Matrice des etats et messages

Ce document formalise le `Lot 6 - Etats et messages` de la phase `P4`.

Il precise les comportements de feedback a couvrir avant implementation pour eviter les zones grises sur les pages et formulaires critiques.

## 1. Objectif

Documenter, pour chaque vue critique, les etats attendus, les messages a afficher et l'action utilisateur suivante.

## 2. Regles globales

- chaque action utilisateur importante doit produire un feedback explicite,
- chaque erreur doit indiquer ce qui bloque et ce que l'utilisateur peut faire,
- les messages doivent etre places pres de l'action ou du contenu concerne,
- un message technique ne doit pas remplacer un message comprehensible,
- les etats d'autorisation doivent distinguer `login requis` et `permission insuffisante`.

## 3. Grammaire de feedback recommandee

- succes : confirmer l'action et la suite logique
- erreur champ : indiquer le champ et la correction attendue
- erreur metier : expliquer la regle qui bloque
- erreur technique : expliquer que l'action a echoue sans exposer de details inutiles
- information : expliquer le contexte ou la consequence

## 4. Matrice des etats par page

| Vue | Etat | Declencheur | Feedback attendu | Action suivante |
| --- | --- | --- | --- | --- |
| `V-PUB-004` Login | initial | page ouverte | formulaire vide, aide minimale | saisir identifiants |
| `V-PUB-004` Login | champ invalide | email ou mot de passe invalide | message sous champ | corriger le champ |
| `V-PUB-004` Login | erreur authentification | identifiants incorrects | alerte erreur globale | reessayer |
| `V-PUB-004` Login | session expiree | retour apres expiration | alerte information | se reconnecter |
| `V-PUB-004` Login | succes | authentification reussie | message optionnel bref | redirection rolee |
| `V-PUB-005` Liste offres | chargement | ouverture ou filtre | skeleton ou placeholder | attendre |
| `V-PUB-005` Liste offres | vide | aucun resultat | etat vide + suggestion | modifier filtres |
| `V-PUB-005` Liste offres | erreur technique | echec chargement | alerte erreur + CTA retry | recharger |
| `V-PUB-006` Detail offre | nominal | offre trouvée | contenu detail | consulter ou agir |
| `V-PUB-006` Detail offre | login requis | anonyme clique `Postuler` | redirection vers `/login` | se connecter |
| `V-PUB-006` Detail offre | permission insuffisante | pilote/admin tente une action etudiant | `403` ou absence du CTA | revenir |
| `V-PUB-006` Detail offre | donnee introuvable | offre absente | `404` | revenir a la liste |
| `V-PUB-007` Liste entreprises | chargement | ouverture | placeholder liste | attendre |
| `V-PUB-007` Liste entreprises | vide | aucun resultat | etat vide | modifier filtres |
| `V-PUB-008` Detail entreprise | nominal | entreprise trouvée | fiche entreprise | consulter offres |
| `V-PUB-008` Detail entreprise | donnee introuvable | entreprise absente | `404` | revenir a la liste |
| `V-ETU-004` Candidature | initial | formulaire ouvert | resume offre + formulaire vide | completer |
| `V-ETU-004` Candidature | champ invalide | champ manquant ou invalide | message champ | corriger |
| `V-ETU-004` Candidature | fichier refuse | format/taille incorrect | alerte ou message champ | changer fichier |
| `V-ETU-004` Candidature | token CSRF invalide | session ou formulaire expire | alerte erreur | recharger puis reessayer |
| `V-ETU-004` Candidature | doublon fonctionnel | candidature deja envoyee | alerte information/erreur metier | revenir detail offre ou candidatures |
| `V-ETU-004` Candidature | succes soumission | candidature creee | alerte succes | aller a `Mes candidatures` |
| `V-ETU-004` Candidature | erreur technique | echec enregistrement | alerte erreur | reessayer |
| `V-ETU-005` Mes candidatures | chargement | ouverture | placeholder tableau | attendre |
| `V-ETU-005` Mes candidatures | vide | aucune candidature | etat vide + CTA offres | aller aux offres |
| `V-ETU-005` Mes candidatures | erreur technique | echec chargement | alerte erreur | recharger |
| `V-PIL-001` Dashboard pilote | nominal | acces autorise | KPI et raccourcis | naviguer |
| `V-PIL-001` Dashboard pilote | erreur technique | donnees indisponibles | alerte erreur + blocs degradés | recharger |
| `V-PIL-002` Liste etudiants pilote | chargement | ouverture | placeholder tableau | attendre |
| `V-PIL-002` Liste etudiants pilote | vide | aucun etudiant visible | etat vide + CTA creation | creer compte |
| `V-PIL-002` Liste etudiants pilote | erreur technique | echec chargement | alerte erreur | recharger |
| `V-PIL-004` Candidatures d'un etudiant | permission insuffisante | etudiant hors promo | `403` | revenir |
| `V-PIL-004` Candidatures d'un etudiant | vide | aucune candidature | etat vide | revenir ou suivre plus tard |
| `V-PIL-004` Candidatures d'un etudiant | erreur technique | echec chargement | alerte erreur | recharger |
| `V-PIL-006` Creation compte etudiant | initial | page ouverte | formulaire vide | completer |
| `V-PIL-006` Creation compte etudiant | champ invalide | donnee invalide | message champ | corriger |
| `V-PIL-006` Creation compte etudiant | email deja utilise | unicite violee | alerte erreur metier | choisir un autre email |
| `V-PIL-006` Creation compte etudiant | succes creation | compte cree | alerte succes | retour liste etudiants |
| `V-PIL-006` Creation compte etudiant | erreur technique | echec creation | alerte erreur | reessayer |
| `V-SYS-001` `403` | acces refuse | route protegee interdite | message clair + retour | revenir |
| `V-SYS-002` `404` | ressource absente | route ou donnee inconnue | message clair + retour accueil | repartir |
| `V-SYS-003` `500` | erreur serveur | incident technique | message clair + CTA accueil | repartir |

## 5. Etats generiques des formulaires critiques

### 5.1 Etats obligatoires

- initial
- focus
- champ invalide
- formulaire invalide
- soumission en cours
- succes
- erreur metier
- erreur technique
- expiration de contexte si applicable

### 5.2 Formulaires concernes

- login
- candidature
- creation de compte etudiant

## 6. Matrice des messages par formulaire

| Formulaire | Cas | Type de message | Contenu attendu |
| --- | --- | --- | --- |
| Login | email invalide | erreur champ | indiquer que l'email n'est pas valide |
| Login | mot de passe vide | erreur champ | indiquer que le mot de passe est requis |
| Login | identifiants incorrects | erreur globale | indiquer que la combinaison email/mot de passe est invalide |
| Login | session expiree | information | indiquer que la session a expire et qu'une reconnexion est requise |
| Candidature | champ vide | erreur champ | indiquer le champ manquant |
| Candidature | fichier non PDF si PDF impose | erreur champ | indiquer le format attendu |
| Candidature | fichier trop lourd | erreur champ | indiquer la limite |
| Candidature | candidature deja existante | erreur metier | indiquer qu'une candidature existe deja pour cette offre |
| Candidature | envoi reussi | succes | confirmer l'envoi et proposer le suivi |
| Creation compte etudiant | champ manquant | erreur champ | indiquer le champ a corriger |
| Creation compte etudiant | email deja utilise | erreur metier | indiquer qu'un compte existe deja |
| Creation compte etudiant | creation reussie | succes | confirmer la creation du compte |

## 7. Regles de placement des messages

- erreur champ : sous le champ concerne
- erreur globale formulaire : au-dessus du formulaire
- succes d'action : au-dessus du contenu principal ou en tete du formulaire
- information de session : en haut de page ou du formulaire
- erreur technique de liste : au-dessus de la liste ou du tableau

## 8. Regles de ton des messages

- court
- explicite
- actionnable
- sans jargon technique expose inutilement

Exemples de ton :

- bon : `Votre candidature a bien ete envoyee.`
- bon : `Cet email est deja utilise.`
- a eviter : `Erreur 0x19 durant la transaction.`

## 9. Etats a ne pas oublier

- tentative d'action protegee en etant anonyme
- tentative d'action interdite avec un role authentifie
- retour sur un formulaire apres echec serveur
- liste vide apres filtre trop restrictif
- succes apres creation de compte
- succes apres candidature
- doublon de candidature
- etudiant hors promo pour le pilote

## 10. Definition of Done du Lot 6

Le `Lot 6` est considere comme exploitable si :

- chaque page critique a ses etats principaux,
- chaque formulaire critique a ses erreurs et succes explicites,
- la difference entre erreur metier et erreur technique est visible,
- les messages sont places de maniere coherente,
- les developpeurs peuvent implementer le feedback sans inventer les cas.
