# Referentiel fonctionnel

Ce document consolide les fonctionnalites attendues par domaine. Il sert de base de backlog et de suivi d'implementation.

## 1. Gestion d'acces

| Code | Fonctionnalite | Resume |
| --- | --- | --- |
| SFx1 | Authentification et gestion des acces | Connexion, deconnexion et protection des zones reservees selon le role. |

## 2. Gestion des entreprises

| Code | Fonctionnalite | Resume |
| --- | --- | --- |
| SFx2 | Rechercher et afficher une entreprise | Recherche multi-criteres, consultation de la fiche, des offres associees et des appreciations. |
| SFx3 | Creer une entreprise | Ajout d'une fiche entreprise. |
| SFx4 | Modifier une entreprise | Mise a jour des informations entreprise. |
| SFx5 | Evaluer une entreprise | Attribution d'une evaluation a une entreprise. |
| SFx6 | Supprimer une entreprise | Retrait logique ou physique d'une entreprise du systeme. |

## 3. Gestion des offres

| Code | Fonctionnalite | Resume |
| --- | --- | --- |
| SFx7 | Rechercher et afficher une offre | Recherche multi-criteres et consultation du detail d'une offre. |
| SFx8 | Creer une offre | Creation d'une offre rattachee a une entreprise et a des competences. |
| SFx9 | Modifier une offre | Mise a jour des informations d'une offre. |
| SFx10 | Supprimer une offre | Retrait d'une offre du systeme. |
| SFx11 | Consulter les statistiques des offres | Affichage de cartes d'indicateurs sur les offres. |

## 4. Gestion des pilotes

| Code | Fonctionnalite | Resume |
| --- | --- | --- |
| SFx12 | Rechercher et afficher un compte pilote | Consultation d'un compte pilote. |
| SFx13 | Creer un compte pilote | Creation d'un compte pilote. |
| SFx14 | Modifier un compte pilote | Modification d'un compte pilote. |
| SFx15 | Supprimer un compte pilote | Suppression d'un compte pilote. |

## 5. Gestion des etudiants

| Code | Fonctionnalite | Resume |
| --- | --- | --- |
| SFx16 | Rechercher et afficher un compte etudiant | Recherche, consultation et suivi de l'etat de recherche de stage. |
| SFx17 | Creer un compte etudiant | Creation d'un compte etudiant. |
| SFx18 | Modifier un compte etudiant | Modification d'un compte etudiant. |
| SFx19 | Supprimer un compte etudiant | Suppression d'un compte etudiant. |

## 6. Gestion des candidatures

| Code | Fonctionnalite | Resume |
| --- | --- | --- |
| SFx20 | Postuler a une offre | Depot d'une candidature avec CV et lettre de motivation. |
| SFx21 | Afficher les offres auxquelles l'etudiant a postule | Consultation par l'etudiant de ses candidatures envoyees. |
| SFx22 | Afficher les offres auxquelles les eleves du pilote ont postule | Consultation par le pilote des candidatures de ses etudiants. |

## 7. Gestion des wish-lists

| Code | Fonctionnalite | Resume |
| --- | --- | --- |
| SFx23 | Afficher les offres ajoutees a la wish-list | Consultation de la liste d'interet d'un etudiant. |
| SFx24 | Ajouter une offre a la wish-list | Ajout d'une offre a la liste d'interet. |
| SFx25 | Retirer une offre de la wish-list | Suppression d'une offre de la liste d'interet. |

## 8. Fonctionnalites transversales

| Code | Fonctionnalite | Resume |
| --- | --- | --- |
| SFx27 | Pagination | Pagination sur toutes les vues listes volumineuses. |
| SFx28 | Mentions legales | Presence des informations legales obligatoires. |

## 9. Remarques de structuration

- Le code `SFx26` n'apparait pas dans le sujet transmis.
- Les fonctionnalites transversales ne figurent pas dans la matrice des permissions fournie.
- La notion de "competences" doit etre traitée comme un referentiel a cadrer des le debut du projet.

## 10. Priorisation proposee

### Priorite 1

- SFx1
- SFx2
- SFx7
- SFx8
- SFx16
- SFx20
- SFx21
- SFx27

### Priorite 2

- SFx3
- SFx4
- SFx9
- SFx11
- SFx17
- SFx18
- SFx22
- SFx23
- SFx24
- SFx25

### Priorite 3

- SFx5
- SFx6
- SFx10
- SFx12
- SFx13
- SFx14
- SFx15
- SFx19
- SFx28

Cette priorisation est une proposition interne de travail. Elle doit etre validee par l'equipe.
