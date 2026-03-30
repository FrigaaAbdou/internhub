# Accessibilite integree

Ce document formalise le `Lot 8 - Accessibilite integree` de la phase `P4`.

Il transforme les exigences d'accessibilite en checklist exploitable pour la conception et l'implementation des ecrans MVP.

## 1. Objectif

Traiter l'accessibilite en amont, directement dans les specs UX, pour eviter des corrections tardives et des blocages en implementation.

## 2. Principes directeurs

- l'accessibilite fait partie de la qualite produit, pas d'une finition optionnelle,
- un ecran n'est pas considere comme pret s'il n'est utilisable qu'a la souris,
- l'information ne doit jamais dependre d'une seule couleur ou d'un seul contexte visuel,
- les messages et actions doivent rester comprehensibles sans ambiguite,
- les patterns d'accessibilite doivent etre portes par les composants communs.

## 3. Exigences minimales de conception

- hierarchie claire des titres,
- labels explicites pour tous les champs,
- messages d'erreur relies aux champs concernes,
- navigation clavier viable,
- contraste suffisant,
- ordre de focus coherent,
- textes de boutons non ambigus,
- alternatives textuelles pour les icones utiles,
- etats visibles au focus et au survol,
- absence de couleur seule comme seul indicateur.

## 4. Checklist navigation et structure

### 4.1 Hierarchie et reperes

- chaque page a un titre principal unique,
- les sections importantes ont des titres secondaires coherents,
- le role ou le contexte de page est identifiable sans effort,
- la navigation principale est clairement distincte du contenu.

### 4.2 Navigation clavier

- tous les liens et boutons sont atteignables au clavier,
- l'ordre de tabulation suit l'ordre logique de lecture,
- le focus visible est toujours present,
- les menus mobiles et tiroirs de navigation sont pilotables au clavier.

### 4.3 Liens et boutons

- le texte d'un lien ou bouton reste comprehensible hors contexte,
- les icones seules sont evitees ou accompagnees d'un libelle,
- les boutons de retour et d'action principale sont distinguables.

## 5. Checklist formulaires

### 5.1 Champs

- chaque champ a un label visible,
- les champs obligatoires sont signales de facon explicite,
- l'aide de saisie est placee pres du champ,
- les placeholders ne remplacent pas les labels.

### 5.2 Erreurs

- les erreurs champs sont associees visuellement et semantiquement au champ,
- l'erreur explique la correction attendue,
- l'utilisateur peut identifier rapidement le premier champ en erreur,
- les erreurs globales ne remplacent pas les erreurs champs quand un champ est en cause.

### 5.3 Soumission

- l'etat de soumission en cours est visible,
- le bouton principal n'induit pas de double soumission,
- le succes d'action est confirme clairement,
- les erreurs metier et techniques restent distinguables.

## 6. Checklist contenu et listes

### 6.1 Tableaux et listes

- les intitulés de colonnes ou etiquettes restent compréhensibles,
- la version mobile d'un tableau conserve la meme information utile,
- les etats vides expliquent l'absence de contenu,
- la pagination reste comprehensible et pilotable.

### 6.2 Cartes et details

- le titre precede les meta informations importantes,
- les informations critiques apparaissent avant les enrichissements secondaires,
- le CTA principal est repérable rapidement,
- les badges de statut ont un libelle textuel compréhensible.

## 7. Checklist messages et feedback

- les messages de succes sont courts et orientent la suite,
- les messages d'erreur restent actionnables,
- les messages d'information n'interrompent pas le parcours sans raison,
- les alertes sont placees pres de la zone concernée,
- les pages `403`, `404`, `500` proposent une sortie claire.

## 8. Checklist responsive et mobile

- la lecture en une colonne reste cohérente,
- les zones tactiles sont suffisamment grandes,
- le contenu principal est priorise sur petit ecran,
- le CTA principal reste accessible sans precision excessive,
- les formulaires longs restent utilisables sans perte de contexte,
- les filtres repliables restent comprehensibles et accessibles.

## 9. Checklist par composant

### `HeaderPublic` et `HeaderRole`

- tous les liens ont un libelle clair,
- le menu mobile peut s'ouvrir et se fermer au clavier,
- l'element actif est discernable sans couleur seule.

### `SidebarRole`

- l'ordre des elements suit la logique des parcours,
- l'item actif est visible,
- les items hors MVP ne se confondent pas avec des actions disponibles.

### `TextField`, `EmailField`, `PasswordField`, `SelectField`, `TextareaField`

- label visible,
- message d'aide optionnel,
- message erreur lie au champ,
- focus visible.

### `FileUploadField`

- consigne de format explicite,
- consigne de taille si limite connue,
- message d'erreur clair en cas de refus.

### `PrimaryButton`, `SecondaryButton`, `DangerButton`

- texte d'action explicite,
- etat desactive discernable,
- etat loading visible si necessaire,
- action destructive clairement identifiee.

### `DataTable`

- colonnes ou etiquettes explicites,
- alternative mobile lisible,
- ligne ou carte focalisable si interaction.

### `Alert`

- type de message compréhensible,
- contenu court,
- pas de jargon technique inutile.

### `StatusBadge`

- texte toujours present,
- pas de dependance exclusive a la couleur.

## 10. Cas critiques a verifier sur le MVP

- connexion clavier seule sur la page login,
- comprehension du CTA `Postuler` sur detail offre,
- soumission de candidature avec erreurs champs,
- lecture des candidatures etudiant sur mobile,
- navigation pilote sur petit ecran,
- acces refuse `403` sur route protegee,
- creation de compte etudiant avec message d'erreur email deja utilise.

## 11. Recommandations de validation

Avant implementation :

- relire chaque wireframe avec cette checklist,
- verifier qu'aucune action critique ne depend d'un survol,
- verifier que chaque message critique a une formulation simple,
- verifier que les patterns communs portent deja leurs contraintes d'accessibilite.

Pendant implementation :

- tester la navigation clavier,
- verifier la visibilite du focus,
- verifier les contrastes,
- tester les formulaires avec erreurs et succes,
- tester les vues critiques sur petit ecran.

## 12. Definition of Done du Lot 8

Le `Lot 8` est considere comme exploitable si :

- les wireframes n'introduisent pas d'obstacle evident,
- les composants portent leurs contraintes d'accessibilite,
- les formulaires et messages respectent les regles de lisibilite et d'action,
- la navigation clavier est prevue,
- les pages critiques du MVP ont ete relues avec cette checklist.
