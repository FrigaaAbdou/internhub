# Roles et permissions

Source : `docs/Matrice_permissions_2025_V2_1.json`

## 1. Roles identifies

- Administrateur
- Pilote
- Etudiant
- Anonyme

## 2. Lecture rapide des droits

### Administrateur

Acces global a presque toutes les fonctionnalites de gestion, sauf :

- postuler a une offre,
- consulter les candidatures personnelles etudiantes,
- consulter la wish-list etudiante.

### Pilote

Acces a :

- authentification,
- consultation des entreprises et des offres,
- creation, modification, suppression d'entreprises,
- creation, modification, suppression d'offres,
- statistiques des offres,
- consultation et gestion des comptes etudiants,
- consultation des candidatures de ses etudiants.

Pas d'acces a :

- gestion des comptes pilotes,
- fonctionnalites etudiantes personnelles,
- wish-list.

### Etudiant

Acces a :

- authentification,
- consultation des entreprises et des offres,
- statistiques des offres,
- candidature,
- suivi de ses candidatures,
- wish-list.

Pas d'acces a :

- creation ou modification d'entreprises,
- creation ou modification d'offres,
- gestion des comptes,
- consultation des autres etudiants.

### Anonyme

Acces public a :

- authentification,
- consultation des entreprises,
- consultation des offres,
- statistiques des offres.

Pas d'acces aux fonctionnalites necessitant un compte.

## 3. Tableau synthetique

| Code | Fonctionnalite | Admin | Pilote | Etudiant | Anonyme |
| --- | --- | --- | --- | --- | --- |
| SFx1 | Authentification et gestion des acces | Oui | Oui | Oui | Oui |
| SFx2 | Rechercher et afficher une entreprise | Oui | Oui | Oui | Oui |
| SFx3 | Creer une entreprise | Oui | Oui | Non | Non |
| SFx4 | Modifier une entreprise | Oui | Oui | Non | Non |
| SFx5 | Evaluer une entreprise | Oui | Oui | Non | Non |
| SFx6 | Supprimer une entreprise | Oui | Oui | Non | Non |
| SFx7 | Rechercher et afficher une offre | Oui | Oui | Oui | Oui |
| SFx8 | Creer une offre | Oui | Oui | Non | Non |
| SFx9 | Modifier une offre | Oui | Oui | Non | Non |
| SFx10 | Supprimer une offre | Oui | Oui | Non | Non |
| SFx11 | Consulter les statistiques des offres | Oui | Oui | Oui | Oui |
| SFx12 | Rechercher et afficher un compte pilote | Oui | Non | Non | Non |
| SFx13 | Creer un compte pilote | Oui | Non | Non | Non |
| SFx14 | Modifier un compte pilote | Oui | Non | Non | Non |
| SFx15 | Supprimer un compte pilote | Oui | Non | Non | Non |
| SFx16 | Rechercher et afficher un compte etudiant | Oui | Oui | Non | Non |
| SFx17 | Creer un compte etudiant | Oui | Oui | Non | Non |
| SFx18 | Modifier un compte etudiant | Oui | Oui | Non | Non |
| SFx19 | Supprimer un compte etudiant | Oui | Oui | Non | Non |
| SFx20 | Postuler a une offre | Non | Non | Oui | Non |
| SFx21 | Voir ses candidatures | Non | Non | Oui | Non |
| SFx22 | Voir les candidatures des etudiants du pilote | Non | Oui | Non | Non |
| SFx23 | Voir la wish-list | Non | Non | Oui | Non |
| SFx24 | Ajouter a la wish-list | Non | Non | Oui | Non |
| SFx25 | Retirer de la wish-list | Non | Non | Oui | Non |

## 4. Points d'attention

- `SFx5 - Evaluer une entreprise` est autorisee pour `Administrateur` et `Pilote`, mais pas pour `Etudiant`. Cette regle merite validation fonctionnelle.
- Les statistiques `SFx11` sont accessibles aux anonymes selon la matrice. Cette ouverture doit etre confirmee.
- Les fonctionnalites transversales `SFx27` et `SFx28` ne sont pas couvertes par la matrice.
- Les permissions definissent les acces fonctionnels, mais pas encore les regles fines de visibilite des donnees.
