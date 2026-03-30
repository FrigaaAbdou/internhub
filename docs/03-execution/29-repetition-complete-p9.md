# P9.6 Repetition complete

Ce document clot `P9.6`.

L objectif de cette etape etait de transformer la repetition en protocole concret et rejouable, pas en intention orale.

## 1. Protocole retenu

La repetition complete est consideree comme valide si elle enchaine :

1. remise a zero du contexte de demo,
2. verification technique complete,
3. verification du fil de demo public,
4. verification du fil etudiant,
5. verification du fil pilote,
6. verification du fil administrateur.

## 2. Script de repetition

Commande officielle :

- `bash scripts/run-soutenance-rehearsal.sh`

Ce script :

- relance `bash scripts/reset-demo-state.sh`,
- rejoue `bash tests/smoke/p8_http_smoke.sh`,
- demarre un serveur local,
- verifie les pages publiques du script de demo,
- verifie les parcours de demonstration `etudiant`, `pilote`, `administrateur`,
- termine par `Soutenance rehearsal passed.` si tout est conforme.

## 3. Resultat attendu

Si le script passe, cela confirme :

- que le contexte de demo est propre,
- que les comptes seeded fonctionnent,
- que les pages du script de demo repondent bien,
- que la repetition peut se faire sans improvisation technique.

## 4. Resultat de reference

Execution de reference :

- `bash scripts/run-soutenance-rehearsal.sh`

Sortie attendue :

- `Soutenance rehearsal passed.`

## 5. Utilisation avant passage jury

Avant une repetition d equipe ou une soutenance :

1. lancer `bash scripts/run-soutenance-rehearsal.sh`
2. si le script echoue, corriger avant toute repetition orale
3. si le script passe, enchaîner la repetition sur le script `P9.1`

## 6. Conclusion de phase

Avec `P9.6`, la soutenance dispose maintenant :

- d un script de demo,
- d un jeu de donnees fige,
- d une documentation de livraison,
- d un argumentaire,
- d une repartition de parole,
- d une repetition technique complete et rejouable.

`P9` peut etre considere comme clos quand l equipe affecte les vrais noms aux slots de parole et rejoue une repetition orale complete.
