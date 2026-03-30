# Specification detaillee - Pages etudiant

Ce document sert de handoff direct pour le web designer sur l'ensemble du perimetre etudiant.

Il couvre les ecrans ou l'etudiant consulte, agit, suit ses candidatures et gere son profil.

Pages couvertes :

- dashboard etudiant,
- formulaire de candidature,
- liste des candidatures,
- detail d'une candidature,
- profil etudiant,
- wish-list.

Objectif :
donner au designer une base complete de travail sans devoir reconstruire seul la logique produit.

Pour chaque page, le document precise :

- le role et le contexte,
- le but produit,
- le contenu obligatoire,
- la hierarchie de la page,
- la structure desktop et mobile,
- les etats obligatoires,
- les points a ne pas inventer.

## 1. Sources de reference

Ce document s'appuie sur :

- [15-inventaire-vues.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/15-inventaire-vues.md)
- [16-navigation-et-parcours.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/16-navigation-et-parcours.md)
- [18-wireframes-structurels-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/18-wireframes-structurels-mvp.md)
- [19-systeme-composants-ui.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/19-systeme-composants-ui.md)
- [20-matrice-etats-formulaires.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/20-matrice-etats-formulaires.md)
- [21-spec-responsive-mobile-first.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/21-spec-responsive-mobile-first.md)
- [22-accessibilite-integree.md](/Users/abdoufrigaa/Projects/internhub/docs/04-ux/22-accessibilite-integree.md)
- [13-validation-mvp.md](/Users/abdoufrigaa/Projects/internhub/docs/03-execution/13-validation-mvp.md)

## 2. Regles de cadrage

Le designer doit garder en tete les regles produit suivantes.

### 2.1 Ce que l'etudiant peut faire

- consulter les offres,
- consulter les entreprises,
- postuler a une offre,
- suivre ses candidatures,
- telecharger son CV deja depose,
- gerer son profil,
- gerer sa wish-list.

### 2.2 Ce que l'etudiant ne peut pas faire

- creer son propre compte publiquement,
- modifier son role,
- modifier sa promotion,
- acceder a des vues pilote ou administrateur,
- gerer les offres ou les entreprises.

### 2.3 Ton UX attendu

L'espace etudiant doit donner une impression de :

- progression,
- clarte,
- suivi,
- simplicité.

Il ne doit pas ressembler a un back-office froid.
Il doit ressembler a un espace de travail personnel oriente action.

## 3. Shell commun de la zone etudiant

Toutes les pages etudiant doivent partager une logique visuelle commune.

### 3.1 Elements obligatoires

- header global,
- contexte role `Etudiant`,
- titre de page clair,
- zone de messages systeme,
- contenu principal,
- actions principales visibles,
- retour ou navigation simple.

### 3.2 Comportement global

- une action principale maximum par zone,
- acces rapides visibles depuis le dashboard,
- tables simplifiees sur mobile,
- vocabulary clair et non administratif,
- priorite a la lisibilite des statuts.

## 4. Page `V-ETU-001` - Dashboard etudiant

Route :
`/dashboard/etudiant`

### 4.1 But produit

Donner a l'etudiant une vue synthese de sa situation et des actions utiles a faire ensuite.

Cette page doit repondre immediatement a trois questions :

- ou en suis-je,
- que puis-je faire maintenant,
- ou retourner rapidement.

### 4.2 Contenu obligatoire

- titre `Dashboard etudiant`,
- message de bienvenue personnalise,
- cartes statistiques,
- bloc `Actions rapides`,
- bloc `Dernieres candidatures`.

### 4.3 Cartes statistiques attendues

- nombre de candidatures,
- nombre d'offres publiees,
- nombre d'entreprises referencees,
- nombre d'elements dans la wish-list.

### 4.4 Actions rapides attendues

- consulter les offres,
- gerer mon profil,
- voir mes candidatures,
- voir ma wish-list,
- consulter les entreprises,
- consulter les statistiques.

### 4.5 Hierarchie visuelle

Ordre recommande :

1. salutation et contexte,
2. cartes stats,
3. actions rapides,
4. dernieres candidatures.

### 4.6 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Eyebrow Etudiant + titre + message d'accueil                                      |
+----------------------------------------------------------------------------------+
| Cartes statistiques                                                                |
| [Candidatures] [Offres] [Entreprises] [Wish-list]                                 |
+----------------------------------------------------------------------------------+
| Actions rapides                                                                    |
| [Consulter les offres] [Profil] [Candidatures] [Wish-list] [Entreprises] [Stats] |
+----------------------------------------------------------------------------------+
| Dernieres candidatures                                                             |
| liste courte avec offre / entreprise / statut / date                              |
+----------------------------------------------------------------------------------+
```

### 4.7 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Eyebrow + titre + message        |
+----------------------------------+
| Carte stat 1                     |
+----------------------------------+
| Carte stat 2                     |
+----------------------------------+
| Carte stat 3                     |
+----------------------------------+
| Carte stat 4                     |
+----------------------------------+
| Actions rapides empilees         |
+----------------------------------+
| Dernieres candidatures           |
+----------------------------------+
```

### 4.8 Etats a designer

- premier acces sans candidature,
- utilisateur actif avec plusieurs candidatures,
- wish-list vide,
- erreur ou absence de donnees recentes.

### 4.9 A ne pas inventer

- pas de timeline complexe de recrutement si elle n'existe pas,
- pas de notes internes,
- pas de widgets fictifs type `matching score`.

## 5. Page `V-ETU-004` - Formulaire de candidature

Route :
`/offres/{id}/postuler`

### 5.1 But produit

Permettre a l'etudiant de postuler simplement a une offre deja choisie.

La page doit reduire le stress et rendre explicites :

- l'offre concernee,
- ce qu'il faut fournir,
- le resultat attendu.

### 5.2 Contenu obligatoire

- rappel du titre d'offre,
- rappel entreprise + localisation,
- formulaire lettre de motivation,
- champ upload CV en PDF,
- messages d'erreur champ par champ,
- bouton principal `Envoyer ma candidature`,
- bouton secondaire `Annuler`.

### 5.3 Hierarchie visuelle

Ordre recommande :

1. contexte de l'offre,
2. formulaire,
3. contraintes fichier,
4. CTA principal.

### 5.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Carte centrale large                                                              |
| Eyebrow candidature                                                               |
| Titre: Postuler a [Nom offre]                                                     |
| Meta: entreprise · lieu                                                           |
|----------------------------------------------------------------------------------|
| Champ: lettre de motivation                                                       |
| Champ: upload CV                                                                  |
| erreurs inline                                                                    |
|----------------------------------------------------------------------------------|
| [Envoyer ma candidature] [Annuler]                                                |
+----------------------------------------------------------------------------------+
```

### 5.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre offre                      |
| entreprise / lieu                |
+----------------------------------+
| Lettre de motivation             |
+----------------------------------+
| Upload CV                        |
+----------------------------------+
| Erreurs inline                   |
+----------------------------------+
| CTA principal                    |
| CTA annuler                      |
+----------------------------------+
```

### 5.6 Etats a designer

- formulaire vide,
- erreurs validation,
- erreur fichier PDF,
- succes apres soumission,
- cas doublon candidature deja existante.

### 5.7 A ne pas inventer

- pas de multi-step form,
- pas de drag-and-drop complexe obligatoire,
- pas de pieces jointes multiples si non prevu.

## 6. Page `V-ETU-005` - Liste des candidatures

Route :
`/dashboard/etudiant/candidatures`

### 6.1 But produit

Permettre a l'etudiant de suivre facilement toutes ses candidatures.

Cette page doit avant tout clarifier le statut de chaque candidature.

### 6.2 Contenu obligatoire

- titre `Mes candidatures`,
- tableau ou liste de candidatures,
- colonnes offre / entreprise / statut / date / actions,
- action `Voir`,
- action `Telecharger le CV` si fichier disponible,
- etat vide.

### 6.3 Hierarchie visuelle

Ordre recommande :

1. titre,
2. eventuel resume ou contexte,
3. liste ou table,
4. actions par ligne.

Le statut doit ressortir plus que la date.

### 6.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Titre page                                                                        |
+----------------------------------------------------------------------------------+
| Tableau candidatures                                                              |
| Offre | Entreprise | Statut | Date | Actions                                      |
| ligne 1                                                                            |
| ligne 2                                                                            |
| ligne 3                                                                            |
+----------------------------------------------------------------------------------+
```

### 6.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre page                       |
+----------------------------------+
| Carte candidature 1              |
| Offre                            |
| Entreprise                       |
| Statut                           |
| Date                             |
| Actions                          |
+----------------------------------+
| Carte candidature 2              |
+----------------------------------+
```

### 6.6 Etats a designer

- liste nominale,
- aucune candidature,
- candidature avec CV disponible,
- candidature sans fichier.

### 6.7 A ne pas inventer

- pas de modification de candidature apres envoi,
- pas de filtre complexe si non prevu dans le produit actuel.

## 7. Page `V-ETU-006` - Detail d'une candidature

Route :
`/dashboard/etudiant/candidatures/{id}`

### 7.1 But produit

Permettre a l'etudiant de consulter le detail d'une candidature sans ambiguite.

### 7.2 Contenu obligatoire

- titre base sur le nom de l'offre,
- meta entreprise / lieu / contrat,
- actions :
  - retour aux candidatures,
  - voir l'offre,
  - telecharger mon CV si disponible,
- section `Suivi`,
- section `Lettre de motivation`.

### 7.3 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Titre candidature                                                                 |
| Meta offre                                                                        |
| Actions principales                                                               |
+-----------------------------------------+----------------------------------------+
| Section suivi                           | actions / CV                            |
| statut, date, fichier                   |                                        |
+-----------------------------------------+----------------------------------------+
| Section lettre de motivation                                                     |
+----------------------------------------------------------------------------------+
```

### 7.4 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre candidature                |
| Meta                             |
| Actions                          |
+----------------------------------+
| Suivi                            |
+----------------------------------+
| Lettre de motivation             |
+----------------------------------+
```

### 7.5 Etats a designer

- avec CV disponible,
- sans CV disponible,
- lettre courte,
- lettre longue.

### 7.6 A ne pas inventer

- pas d'historique RH complet,
- pas de commentaires recruteur si le produit n'en fournit pas.

## 8. Page `V-ETU-002` - Profil etudiant

Route :
`/dashboard/etudiant/profil`

### 8.1 But produit

Permettre a l'etudiant de maintenir ses informations personnelles a jour.

### 8.2 Contenu obligatoire

- titre `Mon profil`,
- explication courte,
- formulaire :
  - prenom,
  - nom,
  - email,
  - role en lecture seule,
  - promotion en lecture seule,
  - nouveau mot de passe optionnel,
- erreurs inline,
- bouton `Enregistrer`,
- retour au dashboard.

### 8.3 Hierarchie visuelle

Ordre recommande :

1. titre + contexte,
2. informations personnelles modifiables,
3. informations verrouillees,
4. changement mot de passe,
5. actions.

### 8.4 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Carte formulaire large                                                            |
| Titre + texte d'aide                                                              |
|----------------------------------------------------------------------------------|
| Prenom                                                                            |
| Nom                                                                               |
| Email                                                                             |
| Role (disabled)                                                                   |
| Promotion (disabled)                                                              |
| Nouveau mot de passe                                                              |
|----------------------------------------------------------------------------------|
| [Enregistrer] [Retour au dashboard]                                               |
+----------------------------------------------------------------------------------+
```

### 8.5 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre + texte d'aide             |
+----------------------------------+
| Prenom                           |
+----------------------------------+
| Nom                              |
+----------------------------------+
| Email                            |
+----------------------------------+
| Role                             |
+----------------------------------+
| Promotion                        |
+----------------------------------+
| Nouveau mot de passe             |
+----------------------------------+
| CTA enregistrer                  |
| CTA retour                       |
+----------------------------------+
```

### 8.6 Etats a designer

- formulaire nominal,
- erreurs champs,
- succes apres sauvegarde,
- changement de mot de passe seul,
- aucun changement sur mot de passe.

### 8.7 A ne pas inventer

- pas de gestion avatar si non prevue,
- pas d'edition du role,
- pas d'edition de la promotion.

## 9. Page `V-ETU-008` - Wish-list

Route :
`/dashboard/etudiant/wishlist`

### 9.1 But produit

Permettre a l'etudiant de garder des offres de cote pour y revenir plus tard.

### 9.2 Contenu obligatoire

- titre `Ma wish-list`,
- CTA retour vers les offres,
- liste ou table des offres sauvegardees,
- action `Voir`,
- action `Retirer`.

### 9.3 Structure desktop

```text
+----------------------------------------------------------------------------------+
| Header protege                                                                    |
+----------------------------------------------------------------------------------+
| Titre + CTA voir les offres                                                       |
+----------------------------------------------------------------------------------+
| Tableau wish-list                                                                 |
| Offre | Entreprise | Contrat | Date | Actions                                     |
+----------------------------------------------------------------------------------+
```

### 9.4 Structure mobile

```text
+----------------------------------+
| Header protege                   |
+----------------------------------+
| Titre + CTA offres               |
+----------------------------------+
| Carte wish-list 1                |
| offre / entreprise / contrat     |
| date / actions                   |
+----------------------------------+
| Carte wish-list 2                |
+----------------------------------+
```

### 9.5 Etats a designer

- wish-list remplie,
- wish-list vide,
- suppression en cours / retour utilisateur.

### 9.6 A ne pas inventer

- pas de systeme favoris multi-dossiers,
- pas de notes personnelles sur les offres si non prevu.

## 10. Regles de style pour l'espace etudiant

Le style attendu doit produire un espace :

- plus chaleureux que l'admin,
- plus guide que la partie publique,
- plus lisible que spectaculaire.

Le designer doit privilegier :

- des CTA nets,
- des statuts visibles,
- des cartes ou tableaux simples,
- des formulaires tres clairs,
- un bon rythme vertical.

## 11. Definition of done du lot design etudiant

Le lot pourra etre considere pret si :

- chaque page etudiant existe en desktop et mobile,
- les etats vides sont prevus,
- les actions principales sont visibles immediatement,
- les statuts de candidature sont lisibles,
- les formulaires sont completement specifiques,
- les variations par role ou par contexte ne contredisent pas le produit.

## 12. Suite recommandee

Apres ce document, la suite logique est :

1. pages pilote,
2. pages administrateur,
3. pages de management CRUD,
4. pages systeme et support.
