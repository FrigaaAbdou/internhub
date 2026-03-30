# P9.4 Argumentaire technique et fonctionnel

Ce document prepare les reponses de soutenance pour `InternHub`.

L objectif n est pas de refaire toute la documentation. L objectif est de disposer de reponses courtes, exactes et defendables aux questions les plus probables du jury.

## 1. Message d ouverture

Formulation courte recommandee :

`InternHub` est une application `PHP MVC` avec acces base via `PDO`, concue pour separer clairement les roles `anonyme`, `etudiant`, `pilote` et `administrateur`. Elle couvre la consultation publique, la candidature etudiante, le suivi pilote d une promotion et la gestion admin, avec une verification rejouable par tests et smoke tests.

## 2. Pourquoi cette architecture

### Pourquoi `PHP MVC` ?

Reponse courte :

- le sujet impose une logique `MVC`,
- cette structure est simple a expliquer en soutenance,
- elle separe presentation, orchestration HTTP et acces aux donnees,
- elle limite le risque de logique metier dispersee dans les vues.

Ce qu il faut pouvoir citer :

- front controller,
- routeur,
- controleurs,
- vues serveur,
- repositories/modeles.

### Pourquoi `PDO` ?

Reponse courte :

- `PDO` etait impose ou fortement attendu dans le cadrage,
- il permet une couche d acces base centralisee,
- il permet l usage de requetes preparees,
- il reste compatible avec la demo SQLite et une cible MySQL.

Ce qu il faut dire si on vous challenge :

- le projet n a pas besoin d un ORM pour son perimetre,
- `PDO` donne un controle simple, lisible et suffisant pour un projet de soutenance.

## 3. Pourquoi ce decoupage fonctionnel

### Pourquoi ces quatre roles ?

Reponse courte :

- ils viennent directement de la matrice de permissions,
- ils couvrent les usages publics, etudiants, pedagogiques et administratifs,
- ils permettent de demontrer une vraie separation des acces.

### Pourquoi le pilote est important ?

Reponse courte :

- sans le pilote, le projet serait presque seulement un site d offres avec login,
- le pilote apporte la supervision de promotion, donc la valeur pedagogique du sujet,
- c est ce role qui justifie les gardes hors promotion et la logique metier specifique.

## 4. Pourquoi ce perimetre MVP

### Pourquoi avoir priorise offres, candidatures et suivi ?

Reponse courte :

- c est le parcours metier le plus demonstrable de bout en bout,
- il montre la consultation publique, l authentification, l action metier et le suivi,
- il permet de justifier les roles sans partir dans un CRUD generique.

### Pourquoi certaines fonctions ont ete moins priorisees au debut ?

Reponse courte :

- on a d abord securise les parcours coeur,
- les fonctions de confort ou de finition ont ete traitees ensuite,
- cela a permis d obtenir rapidement une base demonstrable puis de la stabiliser.

## 5. Comment les droits sont appliques

### Comment garantissez-vous les permissions ?

Reponse courte :

- la source de verite est la matrice JSON,
- les routes protegees passent par des middlewares d authentification et de role,
- les modules sensibles ajoutent des gardes metier quand le role ne suffit pas.

Exemples a citer :

- un etudiant ne peut pas acceder aux routes admin ou pilote,
- un pilote ne peut pas consulter les candidatures hors de sa promotion,
- un anonyme peut consulter les statistiques publiques mais pas les fonctions metier privees.

### Pourquoi le controle serveur est indispensable ?

Reponse courte :

- masquer un bouton dans l interface ne suffit pas,
- le vrai controle doit rester cote serveur,
- c est pour cela que les routes et les actions critiques ont des gardes explicites.

## 6. Comment les donnees sensibles sont protegees

### Comment protegeez-vous les formulaires ?

Reponse courte :

- les routes `POST` sensibles passent par `CSRF`,
- les formulaires injectent un token,
- les saisies sont revalidees cote serveur.

### Comment gerez-vous les candidatures et le CV ?

Reponse courte :

- une candidature est liee a un etudiant et a une offre,
- le doublon etudiant/offre est bloque,
- le telechargement du CV est restreint au bon perimetre,
- les fichiers sont stockes hors du dossier public.

### Comment gerez-vous la session ?

Reponse courte :

- session serveur,
- cookie `HttpOnly`,
- `SameSite`,
- regeneration d identifiant a la connexion et a la deconnexion.

## 7. Comment vous avez verifie le projet

### Comment prouvez-vous que l application tient ?

Reponse courte :

- on n a pas seulement teste a la main,
- il existe un socle `PHPUnit`,
- les phases `P6`, `P7` et `P8` sont rejouables par scripts de smoke.

Exemples concrets a citer :

- `p6_http_smoke.sh` pour le coeur,
- `p7_http_smoke.sh` pour les modules avances,
- `p8_http_smoke.sh` pour la stabilisation complete.

### Pourquoi des smoke tests en plus des tests unitaires ?

Reponse courte :

- les tests unitaires sont utiles pour les briques isolables,
- les smoke tests couvrent les parcours HTTP complets,
- le projet beneficie des deux niveaux sans sur-ingénierie.

## 8. Arbitrages techniques a assumer

### Pourquoi SQLite pour la demo ?

Reponse courte :

- cela simplifie fortement la reproduction locale,
- le projet reste demonstrable sans infrastructure externe,
- le code d acces reste construit autour de `PDO`, donc portable.

### Pourquoi un rendu HTML cote serveur plutot qu un front JS separe ?

Reponse courte :

- ce choix colle au perimetre, au temps imparti et au sujet,
- il reduit la complexite inutile,
- il permet de concentrer l effort sur la logique metier et les droits.

## 9. Limites connues a assumer honnetement

Reponse recommandee :

- le projet est stabilise pour une soutenance, pas industrialise comme un SaaS complet,
- la couverture unitaire reste volontairement minimale,
- certains durcissements de production peuvent encore aller plus loin,
- la base de demo SQLite ne remplace pas une exploitation reelle avec contraintes fortes et supervision ops.

Exemples concrets acceptables a citer :

- pas de tests visuels automatises,
- configuration de demo locale priorisee,
- validation de fichiers perfectible au-dela du niveau de soutenance,
- perimetre volontairement centre sur les cas d usage coeur.

## 10. Questions probables du jury

### Pourquoi ne pas avoir utilise un framework ?

Reponse courte :

- le but etait de montrer la comprehension du socle MVC,
- un micro-socle maison rend l architecture plus visible en soutenance,
- pour ce perimetre, c etait suffisant et pedagogiquement plus justifiable.

### Pourquoi la matrice de permissions est-elle si importante ?

Reponse courte :

- elle joue le role de contrat fonctionnel,
- elle evite les interpretations contradictoires entre roles,
- elle a servi de reference pour les routes, l UX et les tests.

### Comment vous savez que la demo sera stable ?

Reponse courte :

- les comptes et les donnees de demo sont figes,
- un reset officiel existe,
- un script de verification de phase existe,
- la demo est preparee sur des parcours connus.

## 11. Formulation de conclusion

Conclusion courte recommandee :

Nous avons cherche un resultat defendable : une application lisible, fonctionnelle et verifiee, qui montre clairement la separation des roles, le parcours candidature et la supervision pedagogique, sans promettre plus que ce que le projet implemente reellement.

## 12. Prochaine action

Passer a `P9.5 Repartition de la soutenance`.
