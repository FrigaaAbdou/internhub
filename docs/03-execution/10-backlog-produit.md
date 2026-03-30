# Backlog produit

Ce document transforme le cahier des charges en backlog exploitable par l'equipe.

Il sert a :

- prioriser le travail,
- suivre les user stories,
- preparer les sprints,
- justifier les choix de livraison.

## 1. Regles de lecture

### Priorites

- `P1` : indispensable au MVP
- `P2` : important apres stabilisation du coeur
- `P3` : utile mais non bloquant pour la premiere version

### Statuts proposes

- `A faire`
- `A cadrer`
- `Pret pour sprint`
- `En cours`
- `Termine`

### Sprints proposes

- `S0` : cadrage
- `S1` : conception et UX
- `S2` : socle et auth
- `S3` : offres, entreprises, comptes
- `S4` : candidatures, wish-list, suivi pilote
- `S5` : tests, stabilisation, soutenance

## 2. Vision backlog

| Epic | Domaine | Objectif |
| --- | --- | --- |
| E1 | Cadrage et architecture | poser les bases projet et techniques |
| E2 | Authentification et acces | controler les connexions et les droits |
| E3 | Offres | consulter, rechercher et gerer les offres |
| E4 | Entreprises | consulter et gerer les entreprises |
| E5 | Comptes et roles | gerer pilotes, etudiants et redirections role |
| E6 | Candidatures | permettre de postuler et suivre les candidatures |
| E7 | Wish-list | enregistrer les offres favorites |
| E8 | Dashboard pilote | suivre les candidatures de la promo |
| E9 | Statistiques | exposer les indicateurs cles |
| E10 | Qualite, securite et livraison | fiabiliser l'application et preparer la soutenance |

## 3. Backlog par epic

## E1. Cadrage et architecture

| ID | User story | Priorite | Dependances | Sprint | Statut |
| --- | --- | --- | --- | --- | --- |
| BG-001 | En tant qu'equipe, nous voulons valider le MVP afin de concentrer le developpement sur les parcours coeur. | P1 | aucune | S0 | A faire |
| BG-002 | En tant qu'equipe, nous voulons figer les conventions d'architecture pour eviter les divergences de code. | P1 | BG-001 | S0 | A faire |
| BG-003 | En tant qu'equipe, nous voulons definir la convention `Controller / Service / Repository` afin d'avoir une separation technique claire. | P1 | BG-002 | S0 | A faire |
| BG-004 | En tant qu'equipe, nous voulons figer le schema officiel des routes afin d'aligner UX, backend et droits d'acces. | P1 | BG-002 | S1 | A faire |
| BG-005 | En tant qu'equipe, nous voulons produire le MCD et le schema relationnel afin de stabiliser les donnees avant implementation. | P1 | BG-001 | S1 | A faire |

## E2. Authentification et acces

| ID | User story | SFx | Priorite | Dependances | Sprint | Statut |
| --- | --- | --- | --- | --- | --- | --- |
| BG-101 | En tant qu'utilisateur, je veux acceder a la page de connexion afin de m'authentifier. | SFx1 | P1 | BG-004 | S2 | A faire |
| BG-102 | En tant qu'utilisateur, je veux me connecter avec email et mot de passe afin d'acceder a mon espace. | SFx1 | P1 | BG-101, BG-005 | S2 | A faire |
| BG-103 | En tant qu'utilisateur connecte, je veux me deconnecter afin de fermer ma session. | SFx1 | P1 | BG-102 | S2 | A faire |
| BG-104 | En tant que systeme, je veux proteger les routes selon le role afin de bloquer les acces non autorises. | SFx1 | P1 | BG-102 | S2 | A faire |
| BG-105 | En tant que systeme, je veux gerer les erreurs 403, 404 et 500 afin de rendre l'application robuste. | SFx1 | P2 | BG-002 | S2 | A faire |

## E3. Offres

| ID | User story | SFx | Priorite | Dependances | Sprint | Statut |
| --- | --- | --- | --- | --- | --- | --- |
| BG-201 | En tant que visiteur, je veux consulter la liste des offres afin de voir les opportunites disponibles. | SFx7 | P1 | BG-004 | S3 | A faire |
| BG-202 | En tant qu'utilisateur, je veux rechercher et filtrer les offres afin de trouver celles qui correspondent a mon profil. | SFx7 | P1 | BG-201, BG-005 | S3 | A faire |
| BG-203 | En tant qu'utilisateur, je veux consulter le detail d'une offre afin de connaitre l'entreprise, les competences et la remuneration. | SFx7 | P1 | BG-201 | S3 | A faire |
| BG-204 | En tant qu'admin ou pilote, je veux creer une offre afin d'ajouter une opportunite de stage. | SFx8 | P1 | BG-203, BG-302 | S3 | A faire |
| BG-205 | En tant qu'admin ou pilote, je veux modifier une offre afin d'en corriger les informations. | SFx9 | P2 | BG-204 | S3 | A faire |
| BG-206 | En tant qu'admin ou pilote, je veux supprimer une offre afin de la retirer du systeme. | SFx10 | P3 | BG-204 | S4 | A faire |
| BG-207 | En tant qu'utilisateur, je veux naviguer dans les offres avec pagination afin de consulter de gros volumes de resultats. | SFx27 | P1 | BG-201 | S3 | A faire |

## E4. Entreprises

| ID | User story | SFx | Priorite | Dependances | Sprint | Statut |
| --- | --- | --- | --- | --- | --- | --- |
| BG-301 | En tant que visiteur, je veux consulter la liste des entreprises afin d'identifier les structures qui accueillent des stagiaires. | SFx2 | P1 | BG-004 | S3 | A faire |
| BG-302 | En tant qu'utilisateur, je veux consulter la fiche d'une entreprise afin de voir ses informations et ses offres associees. | SFx2 | P1 | BG-301 | S3 | A faire |
| BG-303 | En tant qu'admin ou pilote, je veux creer une entreprise afin d'enregistrer une nouvelle structure. | SFx3 | P2 | BG-302 | S3 | A faire |
| BG-304 | En tant qu'admin ou pilote, je veux modifier une entreprise afin de maintenir les informations a jour. | SFx4 | P2 | BG-303 | S3 | A faire |
| BG-305 | En tant qu'admin ou pilote, je veux evaluer une entreprise afin d'ajouter une appreciation. | SFx5 | P3 | BG-302 | S4 | A cadrer |
| BG-306 | En tant qu'admin ou pilote, je veux supprimer une entreprise afin qu'elle ne soit plus visible. | SFx6 | P3 | BG-303 | S4 | A faire |

## E5. Comptes et roles

| ID | User story | SFx | Priorite | Dependances | Sprint | Statut |
| --- | --- | --- | --- | --- | --- | --- |
| BG-401 | En tant qu'admin, je veux consulter les comptes pilotes afin de gerer les encadrants. | SFx12 | P3 | BG-102 | S4 | A faire |
| BG-402 | En tant qu'admin, je veux creer un compte pilote afin de donner acces a un nouvel encadrant. | SFx13 | P2 | BG-401 | S3 | A faire |
| BG-403 | En tant qu'admin, je veux modifier un compte pilote afin de corriger ses informations. | SFx14 | P3 | BG-402 | S4 | A faire |
| BG-404 | En tant qu'admin, je veux supprimer un compte pilote afin de retirer son acces. | SFx15 | P3 | BG-402 | S4 | A faire |
| BG-405 | En tant qu'admin ou pilote, je veux consulter les comptes etudiants afin de suivre la promotion. | SFx16 | P1 | BG-102 | S3 | A faire |
| BG-406 | En tant qu'admin ou pilote, je veux creer un compte etudiant afin d'ouvrir son acces a la plateforme. | SFx17 | P2 | BG-405 | S3 | A faire |
| BG-407 | En tant qu'admin ou pilote, je veux modifier un compte etudiant afin de garder les informations correctes. | SFx18 | P2 | BG-406 | S4 | A faire |
| BG-408 | En tant qu'admin ou pilote, je veux supprimer un compte etudiant afin de retirer son acces. | SFx19 | P3 | BG-406 | S4 | A faire |
| BG-409 | En tant que systeme, je veux rediriger chaque utilisateur vers le bon dashboard afin d'ameliorer l'experience rolee. | SFx1 | P1 | BG-102 | S2 | A faire |

## E6. Candidatures

| ID | User story | SFx | Priorite | Dependances | Sprint | Statut |
| --- | --- | --- | --- | --- | --- | --- |
| BG-501 | En tant qu'etudiant, je veux acceder au formulaire de candidature depuis une offre afin de postuler facilement. | SFx20 | P1 | BG-203, BG-104 | S4 | A faire |
| BG-502 | En tant qu'etudiant, je veux soumettre une lettre de motivation et un CV afin de finaliser ma candidature. | SFx20 | P1 | BG-501 | S4 | A faire |
| BG-503 | En tant que systeme, je veux bloquer une double candidature sur la meme offre afin d'eviter les doublons. | SFx20 | P1 | BG-502, BG-005 | S4 | A faire |
| BG-504 | En tant qu'etudiant, je veux consulter mes candidatures afin de suivre mes envois. | SFx21 | P1 | BG-502 | S4 | A faire |
| BG-505 | En tant qu'etudiant, je veux pouvoir telecharger le CV associe a une candidature afin de verifier ce que j'ai envoye. | SFx21 | P2 | BG-504 | S4 | A faire |

## E7. Wish-list

| ID | User story | SFx | Priorite | Dependances | Sprint | Statut |
| --- | --- | --- | --- | --- | --- | --- |
| BG-601 | En tant qu'etudiant, je veux ajouter une offre a ma wish-list afin de la retrouver plus tard. | SFx24 | P2 | BG-203, BG-104 | S4 | A faire |
| BG-602 | En tant qu'etudiant, je veux consulter ma wish-list afin de revoir mes offres favorites. | SFx23 | P2 | BG-601 | S4 | A faire |
| BG-603 | En tant qu'etudiant, je veux retirer une offre de ma wish-list afin de garder une liste propre. | SFx25 | P2 | BG-602 | S4 | A faire |
| BG-604 | En tant que systeme, je veux eviter les doublons dans la wish-list afin de garantir la coherence des donnees. | SFx24 | P2 | BG-601, BG-005 | S4 | A faire |

## E8. Dashboard pilote

| ID | User story | SFx | Priorite | Dependances | Sprint | Statut |
| --- | --- | --- | --- | --- | --- | --- |
| BG-701 | En tant que pilote, je veux lister les etudiants de ma promo afin de suivre leur recherche. | SFx16 | P2 | BG-405, BG-005 | S4 | A faire |
| BG-702 | En tant que pilote, je veux consulter les candidatures de mes etudiants afin de suivre leur activite. | SFx22 | P2 | BG-701, BG-504 | S4 | A faire |
| BG-703 | En tant que pilote, je veux telecharger les CV/LM de ma promo afin d'accompagner les etudiants. | SFx22 | P2 | BG-702 | S4 | A faire |
| BG-704 | En tant que systeme, je veux bloquer le pilote hors promo afin de proteger les donnees etudiantes. | SFx22 | P1 | BG-702, BG-005 | S4 | A faire |

## E9. Statistiques

| ID | User story | SFx | Priorite | Dependances | Sprint | Statut |
| --- | --- | --- | --- | --- | --- | --- |
| BG-801 | En tant qu'utilisateur autorise, je veux consulter les statistiques d'offres afin de comprendre l'etat du marche des stages. | SFx11 | P2 | BG-201, BG-204, BG-502 | S5 | A faire |
| BG-802 | En tant que systeme, je veux calculer le nombre moyen de candidatures par offre afin d'alimenter les indicateurs. | SFx11 | P2 | BG-801, BG-005 | S5 | A faire |
| BG-803 | En tant que systeme, je veux calculer le top des offres ajoutees en wish-list afin d'alimenter le carrousel statistique. | SFx11 | P3 | BG-601 | S5 | A faire |

## E10. Qualite, securite et livraison

| ID | User story | SFx | Priorite | Dependances | Sprint | Statut |
| --- | --- | --- | --- | --- | --- | --- |
| BG-901 | En tant que systeme, je veux valider tous les formulaires cote front et back afin de securiser les saisies. | STx3 | P1 | BG-102, BG-204, BG-303, BG-502 | S5 | A faire |
| BG-902 | En tant que systeme, je veux proteger les formulaires critiques par CSRF afin d'eviter les soumissions malveillantes. | STx11 | P1 | BG-102 | S2 | A faire |
| BG-903 | En tant que systeme, je veux stocker la session dans un cookie securise afin de respecter les exigences de securite. | STx11 | P1 | BG-102 | S2 | A faire |
| BG-904 | En tant qu'equipe, nous voulons produire au moins un test unitaire de controleur afin de respecter l'exigence projet. | STx14 | P1 | BG-105 | S5 | A faire |
| BG-905 | En tant qu'equipe, nous voulons rendre l'application responsive afin qu'elle fonctionne sur mobile et desktop. | STx10 | P1 | BG-201, BG-301, BG-501 | S5 | A faire |
| BG-906 | En tant qu'equipe, nous voulons ajouter les mentions legales afin de respecter la conformite minimale. | SFx28 | P2 | BG-004 | S5 | A faire |
| BG-907 | En tant qu'equipe, nous voulons preparer un jeu de donnees de demo afin de soutenir la soutenance. | Projet | P1 | BG-801 | S5 | A faire |
| BG-908 | En tant qu'equipe, nous voulons preparer le script de demonstration afin de presenter une soutenance maitrisée. | Projet | P1 | BG-907 | S5 | A faire |

## 4. MVP recommande

Le MVP devrait inclure au minimum :

- BG-001 a BG-005
- BG-101 a BG-104
- BG-201 a BG-204
- BG-207
- BG-301 a BG-302
- BG-405
- BG-409
- BG-501 a BG-504
- BG-704
- BG-901 a BG-905

## 5. Backlog de sprint recommande

### Sprint 0

- BG-001
- BG-002
- BG-003

### Sprint 1

- BG-004
- BG-005

### Sprint 2

- BG-101
- BG-102
- BG-103
- BG-104
- BG-409
- BG-902
- BG-903

### Sprint 3

- BG-201
- BG-202
- BG-203
- BG-204
- BG-207
- BG-301
- BG-302
- BG-405
- BG-406

### Sprint 4

- BG-501
- BG-502
- BG-503
- BG-504
- BG-601
- BG-602
- BG-603
- BG-604
- BG-701
- BG-702
- BG-704

### Sprint 5

- BG-801
- BG-901
- BG-904
- BG-905
- BG-906
- BG-907
- BG-908

## 6. Critere de passage en sprint

Une user story peut entrer en sprint si :

- son besoin est compris,
- ses dependances sont levees,
- les roles concernes sont connus,
- ses donnees d'entree et de sortie sont identifiees,
- son critere de validation est testable.

## 7. Critere de termine

Une user story est consideree terminee si :

- le comportement attendu fonctionne,
- les droits d'acces sont respectes,
- les validations sont en place,
- le rendu est exploitable en responsive,
- la documentation a ete mise a jour,
- le cas est demontrable.

## 8. Points a arbitrer avant implementation

- BG-305 : droit d'evaluation d'entreprise a confirmer,
- BG-401 a BG-404 : profondeur exacte de la gestion des pilotes,
- BG-801 : niveau de publicite des statistiques,
- BG-906 : contenu exact des mentions legales selon le contexte du projet.
