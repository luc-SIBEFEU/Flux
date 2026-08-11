# Modèle de données — Flux (Réservation hôtelière + Logements)

## 1. Vue d'ensemble

Le modèle est organisé en 4 blocs :

1. **Comptes** — `users` (admin, hôtelier, client, bailleur)
2. **Module Hôtels** — hôtels, chambres, réservations, avis, favoris, actualités
3. **Module Logements** — logements, mini-cités, demandes de baye, bayes, loyers
4. **Transverse** — `photos` (galeries, polymorphique) et `paiements` (polymorphique, MTN MoMo / Orange Money via aangaraa-pay.com)

## 2. Hypothèses / décisions prises (à valider avec toi)

- **Rôle unique par utilisateur** (`users.role`) : un compte est admin, hôtelier, client OU bailleur. Ton texte suggère que "client" et "bailleur" sont deux casquettes différentes (le client paie son loyer "depuis son dashboard, option baye"), ce qui laisse penser qu'**un même compte pourrait cumuler client + bailleur**. Pour l'instant j'ai mis un seul rôle pour rester simple ; si tu veux qu'un utilisateur cumule plusieurs rôles (ex: client ET bailleur), on passera à une table pivot `role_user` — dis-le-moi et j'ajuste la migration `users`.
- **Notes sur 10** : `avis_hotels.note` et `commentaires_logements.note` sont des `tinyint` (0–10). La moyenne (`hotels.note_moyenne`) est stockée en cache et recalculée à chaque nouvel avis **approuvé** (dénormalisation utile pour trier/filtrer rapidement).
- **Galeries photo polymorphiques** : une seule table `photos` (`photoable_id` / `photoable_type`) sert pour hôtels, catégories de chambres, logements et mini-cités — évite de dupliquer 4 tables quasi identiques.
- **Paiements polymorphiques** : une seule table `paiements` (`payable_id` / `payable_type`) sert pour les réservations d'hôtel ET les loyers — un seul point d'intégration avec l'API aangaraa-pay.com.
- **Équipements partagés** : table `equipements` (wifi, piscine, climatisation, douche interne, eau...) réutilisée à la fois par `categorie_chambres` (pivot `categorie_chambre_equipement`) et par `logements` (pivot `logement_equipement`), avec un champ `contexte` pour filtrer la liste proposée selon qu'on édite un hôtel ou un logement.
- **Génération automatique de chambres pour une mini-cité** : quand le bailleur ajoute un logement à une mini-cité en précisant "j'en ai N", on crée N lignes dans `logements` avec des id différents. `logements.logement_modele_id` garde une référence vers le "modèle" d'origine pour pouvoir gérer le groupe (modifier le prix de toutes les chambres du même type en une fois, par exemple).
- **Suivi de séjour hôtel** : géré directement via `reservations.statut` (en_attente → confirmee → terminee, ou annulee). Le client suit son séjour depuis "mes réservations".
- **Cycle de vie d'un baye (logement)** :
  `demandes_baye` (nouveau) → validation bailleur + paiement initial ok → création d'une ligne `bayes` (statut nouveau → en_cours) → génération mensuelle de `loyers` → `bayes.statut = termine` quand la durée est écoulée, avec possibilité de `prolongations`.
- **Statut du logement** : `logements.statut` passe à `loue` dès qu'un `baye` est `en_cours`, ce qui le retire automatiquement des résultats publics (à gérer via un observer/event sur `bayes`).

## 3. Liste des tables

| Table | Rôle |
|---|---|
| `users` | admin / hôtelier / client / bailleur |
| `actualites` | actualités de la page d'accueil |
| `hotels` | fiche hôtel (créée par l'hôtelier, validée par l'admin) |
| `hotel_reseaux_sociaux` | liens réseaux sociaux d'un hôtel |
| `hotel_contacts_paiement` | numéros MoMo/OM de l'hôtelier |
| `equipements` | référentiel d'accessoires partagé hôtel/logement |
| `categorie_chambres` | catégories de chambres d'un hôtel |
| `categorie_chambre_equipement` | pivot équipements ↔ catégorie de chambre |
| `photos` | galerie polymorphique (hôtel, chambre, logement, mini-cité) |
| `reservations` | réservation d'une chambre par un client |
| `paiements` | paiement polymorphique (réservation ou loyer) via aangaraa-pay.com |
| `avis_hotels` | avis + note client sur un hôtel (modération admin) |
| `favoris` | hôtels mis en favoris par un client |
| `minicites` | mini-cité d'un bailleur |
| `logements` | chambre / studio / appartement / villa |
| `logement_equipement` | pivot équipements ↔ logement |
| `bailleur_contacts_paiement` | numéros MoMo/OM du bailleur |
| `demandes_baye` | demande initiale du client ("Contacter le bailleur") |
| `bayes` | contrat de location actif/terminé |
| `loyers` | échéances mensuelles d'un baye |
| `prolongations` | historique des demandes de prolongation |
| `commentaires_logements` | avis + note client sur un logement |

## 4. Relations clés

```
users (1) ───< hotels (hotelier_id)
hotels (1) ───< categorie_chambres ───< reservations >─── users (client)
hotels (1) ───< avis_hotels >─── users (client)
hotels (1) ───< favoris >─── users (client)
hotels (1) ───< hotel_reseaux_sociaux
hotels (1) ───< hotel_contacts_paiement
[hotels | categorie_chambres | logements | minicites] ───< photos (polymorphique)
[reservations | loyers] ───< paiements (polymorphique)

users (bailleur) ───< minicites ───< logements
users (bailleur) ───< logements (direct, sans mini-cité)
logements ───< demandes_baye >─── users (client)
demandes_baye (1) ─── (0..1) bayes
bayes (1) ───< loyers
bayes (1) ───< prolongations
logements ───< commentaires_logements >─── users (client)
```

## 5. Contenu du zip

```
database_model/
├── ERD.md                                  (ce document)
└── migrations/                             (22 fichiers, à copier dans database/migrations)
    ├── 0001_01_01_000000_create_users_table.php   (remplace la migration users par défaut)
    ├── 2025_01_01_000001_create_actualites_table.php
    ├── ... (voir liste ci-dessus, un fichier par table, dans l'ordre de dépendance)
    └── 2025_01_01_000021_create_commentaires_logements_table.php
```

## 6. Prochaines étapes possibles

- Générer les **modèles Eloquent** correspondants (relations, casts, scopes) + **factories/seeders** de démo
- Ajouter **Spatie Laravel-Permission** si tu veux des rôles/permissions plus fins que la colonne `role`
- Définir les **routes + contrôleurs** par rôle (admin/hotelier/client/bailleur)
- Écrire les **jobs planifiés** : génération mensuelle des `loyers`, passage `bayes.statut = termine`, passage `loyers.statut = en_retard`
