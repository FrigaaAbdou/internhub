# P9.2 Jeu de donnees et comptes de demo

Ce document fige le contexte de demonstration de `InternHub`.

L objectif est de supprimer toute ambiguite avant la soutenance :

- quels comptes utiliser,
- quelles donnees doivent etre presentes,
- comment remettre l application dans un etat propre avant une repetition,
- quels elements ne doivent pas etre modifies pendant la demo.

## 1. Comptes de demonstration officiels

Comptes a utiliser :

- `admin@internhub.test` / `Admin123!`
- `pilot@internhub.test` / `Pilot123!`
- `student@internhub.test` / `Student123!`

Compte secondaire utile pour illustrer la promotion :

- `lina@internhub.test` / `Student123!`

Regle :

- ces comptes doivent rester figes pour la soutenance,
- ils ne doivent pas etre renommes ni remplaces par des comptes improvises,
- toute repetition doit repartir de ce meme jeu d identifiants.

## 2. Etat de donnees attendu

Apres remise a zero officielle, l application doit contenir au minimum :

- `1` promotion : `Promotion 2026`,
- `1` administrateur,
- `1` pilote,
- `2` etudiants,
- `3` entreprises,
- `4` offres publiees,
- `2` candidatures deja deposees,
- `1` CV de demonstration telechargeable,
- statistiques publiques non vides.

Jeu de donnees metier attendu :

- les candidatures de demonstration appartiennent a `Emma Student`,
- elles pointent vers les deux premieres offres publiees,
- leur statut est `envoyee`,
- leur fichier associe est `uploads/demo/demo-student-cv.pdf`.

## 3. Commande officielle de remise a zero

Commande unique a utiliser avant chaque repetition :

- `bash scripts/reset-demo-state.sh`

Ce script :

- supprime la base SQLite courante,
- nettoie les sessions runtime,
- nettoie les logs runtime,
- nettoie les uploads runtime,
- reconstruit la base de demonstration,
- regenere le CV PDF de demonstration.

## 4. Etat garanti apres reset

Apres execution du reset officiel :

- la base SQLite est reconstruite,
- les comptes de demonstration sont recrees,
- les candidatures seeded sont presentes,
- le CV de demonstration existe physiquement,
- les sessions precedentes ne perturbent plus la connexion,
- les uploads residuels d anciennes repetitions sont supprimes.

## 5. Donnees a ne pas manipuler pendant la soutenance

Pour garder une demo stable, eviter en direct :

- suppression definitive d un compte officiel,
- suppression definitive d une entreprise seeded,
- suppression definitive d une offre seeded,
- modification des mots de passe de demo,
- depots improvises de nouveaux fichiers si cela n apporte rien au parcours montre.

Si une repetition modifie l etat de la base :

- relancer immediatement `bash scripts/reset-demo-state.sh`.

## 6. Verification rapide avant passage

Checklist minimale avant une soutenance ou une repetition :

1. lancer `bash scripts/reset-demo-state.sh`
2. verifier la connexion avec `student@internhub.test`
3. verifier la connexion avec `pilot@internhub.test`
4. verifier la connexion avec `admin@internhub.test`
5. verifier que `/statistiques` affiche des indicateurs non vides
6. verifier qu une candidature etudiante ouvre bien un CV telechargeable

## 7. Resultat du lot

`P9.2` est considere comme valide si :

- les comptes de demo sont figes,
- le jeu de donnees de demo est decrit,
- une commande officielle de reset existe,
- le reset remet bien l application dans un etat presentable.

## 8. Prochaine action

Passer a `P9.3 Documentation finale de livraison`.
