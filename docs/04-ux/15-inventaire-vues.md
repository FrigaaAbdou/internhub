# Inventaire des vues

Ce document lance le `Lot 1 - Inventaire UX officiel` de la phase `P4`.

Il recense les vues a concevoir a partir :

- du MVP valide,
- des roles valides,
- de la matrice de permissions,
- des routes deduites dans les UML.

## 1. Regles de lecture

### Source de verite

Pour les permissions :
`docs/05-sources/permissions/Matrice_permissions_2025_V2_1.json`

Pour le perimetre MVP :
`docs/03-execution/13-validation-mvp.md`

Pour les routes actuellement connues :
`docs/02-architecture/08-analyse-uml.md`

### Statuts utilises

- `MVP` : vue indispensable au perimetre valide
- `P2+` : vue utile mais reportee apres le MVP
- `A arbitrer` : vue ou route encore non stabilisee

### Convention de role

- `Public` = `Anonyme` + pages accessibles sans authentification
- `Etudiant`
- `Pilote`
- `Administrateur`

## 2. Hypotheses de travail

- Les routes ci-dessous constituent un inventaire UX de depart et non encore le schema officiel final de routage.
- Une vue n'est consideree "autorisée" que si ses actions respectent la matrice de permissions.
- Une meme vue peut exister pour plusieurs roles, mais les actions affichees doivent varier selon le role.
- La route `/register` reste inventorisee parce qu'elle apparait dans les UML, mais elle n'entre pas dans le MVP et reste a arbitrer.

## 3. Catalogue des vues publiques

| ID vue | Route candidate | Statut | Roles autorises | But principal | Donnees affichees | Actions principales | Dependances |
| --- | --- | --- | --- | --- | --- | --- | --- |
| V-PUB-001 | `/` | MVP | Public, Etudiant, Pilote, Administrateur | Point d'entree du site | proposition de valeur, acces rapide, liens vers offres et entreprises | acceder aux offres, acceder aux entreprises, aller vers login | navigation publique, contenu editorial minimal |
| V-PUB-002 | `/landing` | P2+ | Public, Etudiant, Pilote, Administrateur | Variante marketing ou page d'accueil detaillee | sections de presentation, CTA, informations projet | consulter les offres, consulter les entreprises, aller vers login | contenu editorial, navigation publique |
| V-PUB-003 | `/about` | P2+ | Public, Etudiant, Pilote, Administrateur | Presenter la plateforme et le contexte | presentation projet, objectifs, equipe, contexte | revenir a l'accueil, aller vers offres | contenu editorial |
| V-PUB-004 | `/login` | MVP | Public, Etudiant, Pilote, Administrateur | Authentifier l'utilisateur | formulaire email, mot de passe, message d'erreur, feedback | se connecter | session, CSRF, redirection par role |
| V-PUB-005 | `/offres` | MVP | Public, Etudiant, Pilote, Administrateur | Rechercher et lister les offres | liste paginee, filtres, cartes ou tableau, resume entreprise | filtrer, paginer, ouvrir une offre | SFx7, SFx27, donnees offres + entreprises + competences |
| V-PUB-006 | `/offres/{id}` | MVP | Public, Etudiant, Pilote, Administrateur | Consulter le detail d'une offre | details offre, entreprise associee, competences, description | revenir a la liste, postuler si etudiant, aller vers login si non connecte | SFx7, controle de visibilite des actions |
| V-PUB-007 | `/entreprises` | MVP | Public, Etudiant, Pilote, Administrateur | Rechercher et lister les entreprises | liste paginee, filtres simples, informations synthese | filtrer, paginer, ouvrir une entreprise | SFx2, SFx27 |
| V-PUB-008 | `/entreprises/{id}` | MVP | Public, Etudiant, Pilote, Administrateur | Consulter la fiche d'une entreprise | informations entreprise, offres associees, eventuelles appreciations | revenir a la liste, ouvrir une offre associee | SFx2, donnees entreprise + offres |
| V-PUB-009 | `/register` | A arbitrer | Public | Auto-inscription publique potentielle | formulaire d'inscription si retenu | creer un compte | contradictoire avec la creation admin/pilote des comptes etudiants |
| V-PUB-010 | `/logout` | MVP | Etudiant, Pilote, Administrateur | Fermer la session | message de deconnexion ou redirection | se deconnecter | session |

## 4. Catalogue des vues etudiant

| ID vue | Route candidate | Statut | Roles autorises | But principal | Donnees affichees | Actions principales | Dependances |
| --- | --- | --- | --- | --- | --- | --- | --- |
| V-ETU-001 | `/dashboard/etudiant` | P2+ | Etudiant | Point d'entree etudiant apres login | resume candidatures, raccourcis, rappel profil | aller vers offres, candidatures, profil, wishlist si retenue | redirection post-login, widgets dashboard |
| V-ETU-002 | `/profil` | P2+ | Etudiant | Consulter son espace personnel | informations compte, promo, etat de recherche si retenu | modifier son profil si retenu | arbitrage avec SFx16, donnees compte |
| V-ETU-003 | `/profil/edit` | P2+ | Etudiant | Modifier son profil personnel si retenu | formulaire profil | enregistrer modifications | arbitrage fonctionnel, validation, CSRF |
| V-ETU-004 | `/offres/{id}/postuler` | MVP | Etudiant | Soumettre une candidature | rappel offre, formulaire lettre, upload CV, messages | envoyer candidature, revenir au detail offre | SFx20, CSRF, upload, validation, unicite candidature |
| V-ETU-005 | `/dashboard/etudiant/candidatures` | MVP | Etudiant | Voir la liste de ses candidatures | liste des offres postulees, statuts, date, pagination si necessaire | ouvrir une candidature, ouvrir l'offre associee | SFx21 |
| V-ETU-006 | `/candidatures/{id}` | P2+ | Etudiant | Consulter le detail d'une candidature | offre, date, documents, statut, message de confirmation | telecharger CV si retenu, revenir a la liste | detail candidature, controle proprietaire |
| V-ETU-007 | `/candidatures/{id}/cv` | P2+ | Etudiant | Recuperer le CV soumis | fichier ou metadata du CV | telecharger le CV | stockage fichier, controle proprietaire |
| V-ETU-008 | `/dashboard/etudiant/wishlist` | P2+ | Etudiant | Consulter la wishlist | liste des offres sauvegardees | ouvrir une offre, retirer une offre | SFx23 a SFx25, hors MVP |

## 5. Catalogue des vues pilote

| ID vue | Route candidate | Statut | Roles autorises | But principal | Donnees affichees | Actions principales | Dependances |
| --- | --- | --- | --- | --- | --- | --- | --- |
| V-PIL-001 | `/dashboard/pilote` | MVP | Pilote | Point d'entree pilote apres login | indicateurs de suivi, acces etudiants, acces candidatures | consulter etudiants, consulter candidatures promo | redirection post-login, resume promo |
| V-PIL-002 | `/dashboard/pilote/etudiants` | MVP | Pilote | Lister les etudiants de sa promotion | liste etudiants, informations synthese, recherche simple, pagination si necessaire | ouvrir un etudiant, creer un compte etudiant | SFx16, SFx17, filtre par promo |
| V-PIL-003 | `/dashboard/pilote/etudiants/{id}` | P2+ | Pilote | Consulter la fiche d'un etudiant de sa promotion | donnees compte, etat de recherche, actions autorisees | voir candidatures, modifier compte si retenu | SFx16, controle d'appartenance promo |
| V-PIL-004 | `/dashboard/pilote/etudiants/{id}/candidatures` | MVP | Pilote | Consulter les candidatures d'un etudiant de sa promotion | liste des offres postulees, dates, pieces associees | ouvrir un document, revenir a la liste etudiants | SFx22, filtre par promo |
| V-PIL-005 | `/pilote/candidatures/{id}/cv` | P2+ | Pilote | Consulter ou telecharger le document d'une candidature | document CV/LM ou metadata | telecharger un document | stockage fichier, controle par promo |
| V-PIL-006 | `/dashboard/pilote/etudiants/create` | MVP | Pilote | Creer un compte etudiant | formulaire compte etudiant | creer le compte | SFx17, validation, CSRF, route finale a confirmer dans le schema officiel |

## 6. Catalogue des vues administrateur

| ID vue | Route candidate | Statut | Roles autorises | But principal | Donnees affichees | Actions principales | Dependances |
| --- | --- | --- | --- | --- | --- | --- | --- |
| V-ADM-001 | `/dashboard/admin` | P2+ | Administrateur | Point d'entree admin | raccourcis de gestion, indicateurs, acces modules | aller vers comptes, offres, entreprises, stats | redirection post-login |
| V-ADM-002 | `/admin/comptes` | P2+ | Administrateur | Gérer les comptes pilote et etudiant | liste comptes, roles, statuts | creer, modifier, supprimer, consulter | SFx12 a SFx19 |
| V-ADM-003 | `/admin/comptes/create` | P2+ | Administrateur | Creer un compte pilote ou etudiant | formulaire de creation de compte | creer un compte | SFx13, SFx17, validation, CSRF |
| V-ADM-004 | `/admin/comptes/{id}/edit` | P2+ | Administrateur | Modifier un compte pilote ou etudiant | formulaire edition | enregistrer modifications, supprimer si retenu | SFx14, SFx18, SFx15, SFx19 |
| V-ADM-005 | `/admin/entreprises` | P2+ | Administrateur | Gerer les entreprises | liste, recherche, statuts | creer, modifier, supprimer | SFx3 a SFx6 |
| V-ADM-006 | `/admin/entreprises/create` | P2+ | Administrateur | Creer une entreprise | formulaire entreprise | enregistrer entreprise | SFx3 |
| V-ADM-007 | `/admin/entreprises/{id}/edit` | P2+ | Administrateur | Modifier une entreprise | formulaire entreprise, evaluation si retenue ici | enregistrer, supprimer, evaluer | SFx4 a SFx6 |
| V-ADM-008 | `/admin/offres` | P2+ | Administrateur | Gerer les offres | liste, recherche, statuts | creer, modifier, supprimer | SFx8 a SFx10 |
| V-ADM-009 | `/admin/offres/create` | P2+ | Administrateur | Creer une offre | formulaire offre, association entreprise, competences | enregistrer offre | SFx8 |
| V-ADM-010 | `/admin/offres/{id}/edit` | P2+ | Administrateur | Modifier une offre | formulaire offre | enregistrer, supprimer | SFx9, SFx10 |
| V-ADM-011 | `/admin/stats` | P2+ | Administrateur | Consulter les statistiques detaillees | cartes indicateurs, tendances, comparatifs | filtrer, consulter indicateurs | SFx11, hors MVP |

## 7. Catalogue des vues systeme

| ID vue | Route candidate | Statut | Roles autorises | But principal | Donnees affichees | Actions principales | Dependances |
| --- | --- | --- | --- | --- | --- | --- | --- |
| V-SYS-001 | `403` | MVP | Tous | Signaler un acces refuse | message d'erreur, action de retour | revenir, se connecter si pertinent | gestion erreurs |
| V-SYS-002 | `404` | MVP | Tous | Signaler une ressource introuvable | message d'erreur, lien retour | revenir a l'accueil ou a la liste | gestion erreurs |
| V-SYS-003 | `500` | MVP | Tous | Signaler une erreur serveur | message d'erreur, action retour | revenir a l'accueil | gestion erreurs |

## 8. Vues MVP a concevoir en premier

Les vues a produire en priorite absolue pour le design et l'implementation sont :

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
- `V-SYS-001` a `V-SYS-003` pages d'erreur

## 9. Ecarts et arbitrages detectes

- `/register` reste incompatible avec l'absence d'auto-inscription etudiante ; la vue est inventoriee mais non validee.
- Les routes melangent francais et anglais ; l'inventaire conserve les noms issus des UML tant que le schema officiel n'est pas fige.
- Certaines vues admin existent dans les UML mais restent hors MVP.
- `dashboard/etudiant` et `profil` sont identifies, mais hors MVP a ce stade.
- La route de creation de compte etudiant cote pilote n'est pas stabilisee dans les UML ; elle devra etre alignee avec le futur schema officiel des routes.

## 10. Critere de sortie du Lot 1

Le `Lot 1` pourra etre considere comme exploitable si :

- toutes les vues MVP sont recensees,
- chaque vue indique clairement ses roles autorises,
- chaque vue indique ses actions principales,
- les dependances critiques sont visibles,
- les contradictions connues sont tracees,
- aucune vue ne contredit la matrice de permissions.
