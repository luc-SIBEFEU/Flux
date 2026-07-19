# Flux — Site de réservation hôtelière (Laravel 13 + Blade)

Version **100% Blade classique** (contrôleurs + vues, sans Livewire/Flux) —
formulaires en GET pour les filtres/recherche, CRUD classiques
create/store/edit/update/destroy pour l'admin et l'hôtelier.

## 1. Installation
Ouvrez un terminal depuis le dossier du proget
```bash
composer install
php artisan key:generate
```

Les vues email utilisent les composants Markdown Mail de Laravel
(`x-mail::message`, déjà inclus par défaut). Si tu veux personnaliser leur
style, publie-les avec :
```bash
php artisan vendor:publish --tag=laravel-mail
```

## 2. Configuration `.env`

```env
DB_CONNECTION=mysql
DB_DATABASE=hotel_booking
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public

MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS="reservations@tonsite.com"
MAIL_FROM_NAME="Flux"

# API officielle MTN Mobile Money (Collections) — https://momodeveloper.mtn.com
MTN_MOMO_BASE_URL=https://sandbox.momodeveloper.mtn.com
MTN_MOMO_SUBSCRIPTION_KEY=
MTN_MOMO_API_USER=
MTN_MOMO_API_KEY=
MTN_MOMO_TARGET_ENV=sandbox

# API officielle Orange Money Web Payment — https://developer.orange.com/apis/om-webpay
ORANGE_MONEY_BASE_URL=https://api.orange.com
ORANGE_MONEY_CLIENT_ID=
ORANGE_MONEY_CLIENT_SECRET=
ORANGE_MONEY_MERCHANT_KEY=
```

Comme les emails de pro-forma sont envoyés via une file d'attente
(`ShouldQueue`), configure aussi un driver de queue (database, redis...) et
lance un worker :
```bash
QUEUE_CONNECTION=database
php artisan queue:table && php artisan migrate
php artisan queue:work
```
(Ou passe temporairement `QUEUE_CONNECTION=sync` en développement pour un
envoi immédiat sans worker.)

## 3. Base de données & stockage

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

Comptes de démonstration créés par le seeder (mot de passe : `password`) :
- **Admin** : admin@hotelbooking.test
- **Hôtelier** : hotelier@hotelbooking.test
- **Client** : client@hotelbooking.test

## 4. Lancer le projet

```bash
npm install
npm run dev
php artisan serve
```

## Fonctionnalités clés de cette version

- **100% Blade** : recherche/filtres hôtels via formulaires GET (query string,
  paginé avec `withQueryString()`), CRUD admin/hôtelier via routes resource
  classiques (create/store/edit/update/destroy), pas de JS requis.
- **Logo d'hôtel** : chaque hôtel a désormais un champ `logo` (en plus de
  l'image de couverture), affiché sur la carte, la fiche détail et dans
  l'email de pro-forma.
- **Pro-forma par email** : dès que le client valide sa réservation
  (`ReservationController@store`), un email `ReservationProforma` (Markdown
  Mail, avec le logo de l'hôtel) est envoyé au client avec le récapitulatif
  complet et le montant à payer. Il est mis en file d'attente (`ShouldQueue`).
- **AangaraaPay (vraie doc)** : `AangaraaPayService` utilise le **paiement
  direct** (`POST /no_redirect/payment`) avec `phone_number`, `amount`,
  `app_key`, `transaction_id`, `notify_url`, `operator` (`MTN_Cameroon` /
  `Orange_Cameroon`), puisqu'on a déjà le numéro du client dans le
  formulaire. Le statut est mis à jour via le webhook `notify_url`
  (`routes/web.php` → `/paiement/webhook`) ou en interrogeant
  `POST /aangaraa_check_status` avec le `payToken`.

## ⚠️ À vérifier avant la mise en production

1. **Format exact du webhook AangaraaPay** : le mapping des statuts
   (`SUCCESSFUL`, `PENDING`, `FAILED`, `CANCELLED`, `EXPIRED`) et les noms de
   champs (`payToken`, `transaction_id`, `status`) sont basés sur la doc
   fournie ; revérifie-les si l'API évolue.
2. **Numéro de téléphone** : `AangaraaPayService::formaterNumero()` normalise
   au format `237XXXXXXXXX`. Adapte l'indicatif si tu cibles d'autres pays.
3. **Disponibilité réelle sur les dates recherchées** : `Hotel::scopeRechercher()`
   filtre sur la capacité des chambres mais pas encore sur leur disponibilité
   à la date précise (voir `RoomCategory::estDisponible()` pour croiser les
   deux si besoin).

## Structure des rôles

| Rôle | Accès |
|---|---|
| `client` | réservation, avis, favoris, profil |
| `hotelier` | gestion de ses hôtels/chambres/galeries (+ logo), réservations reçues, contacts paiement |
| `admin` | actualités, validation hôtels, gestion utilisateurs, modération avis, rapports |

## Palette de couleurs

Bleu (`#1d4ed8`), Blanc, Violet (`#6d28d9`), Noir (`#0d0620`), Or (`#fbbf24`) —
définis dans `tailwind.config.js`.
