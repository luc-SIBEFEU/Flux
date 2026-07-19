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

Rennomez `.env.example` en `.env` et completez ou remplacez où c'est necessaire
```env
DB_CONNECTION=mysql
DB_DATABASE=flux_db
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
- **Paiement MTN MoMo / Orange Money avec bascule automatique** :
  `PaymentManager` est le point d'entrée unique appelé par
  `ReservationController@store`. Pour chaque paiement, il vérifie si les
  identifiants API de l'opérateur concerné sont configurés dans `.env` :
    - **Configurés** → appel réel à l'API officielle (`MtnMomoService` pour
      un "Request to Pay" — prompt sur le téléphone du client — ou
      `OrangeMoneyService` pour une session "Web Payment" avec redirection).
    - **Non configurés (par défaut)** → **mode manuel** : le client est
      redirigé vers une page d'instructions (`/paiement/{payment}/instructions`)
      lui indiquant le numéro MoMo/Orange de l'hôtelier (renseigné dans
      *Contacts de paiement*) et le montant à envoyer lui-même. Il saisit
      ensuite la référence de transaction reçue par SMS, que l'hôtelier
      confirme manuellement depuis sa liste de réservations (bouton
      *"Confirmer paiement"*), ce qui passe la réservation à `confirmee`.
  Ce mode manuel permet de mettre le site en ligne dès maintenant, en
  attendant l'obtention des clés API MTN MoMo / Orange Money.

## ⚠️ À vérifier avant la mise en production

1. **MTN MoMo** : `MtnMomoService` suit le flux standard "Collections /
   Request to Pay" (bien documenté sur momodeveloper.mtn.com), mais les URL
   de production et la procédure d'obtention des identifiants sont
   négociées pays par pays avec MTN — à confirmer une fois ton compte Cameroun
   validé.
2. **Orange Money** : `OrangeMoneyService` utilise l'API publique "Web
   Payment" (flux par **redirection**, le client quitte temporairement le
   site pour confirmer sur la page Orange). Si Orange t'a donné accès à une
   API différente pour le Cameroun (paiement direct via partenariat), il
   faudra adapter ce service en conséquence — le endpoint
   `transactionstatus` notamment est à revérifier avec ta documentation
   exacte une fois ton compte marchand actif.
3. **Numéro de téléphone MTN** : `MtnMomoService::formaterNumero()` normalise
   au format `237XXXXXXXXX`. Adapte l'indicatif si tu cibles d'autres pays.
4. **Mode manuel** : tant que les clés API ne sont pas renseignées, TOUS les
   paiements passent en mode manuel automatiquement — pense à bien
   renseigner les numéros MoMo/Orange de chaque hôtelier (page *Contacts de
   paiement*), sinon le client ne saura pas où envoyer l'argent.
5. **Disponibilité réelle sur les dates recherchées** : `Hotel::scopeRechercher()`
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

## Structure des rôles

| Rôle | Accès |
|---|---|
| `client` | réservation, avis, favoris, profil |
| `hotelier` | gestion de ses hôtels/chambres/galeries (+ logo), réservations reçues, contacts paiement |
| `admin` | actualités, validation hôtels, gestion utilisateurs, modération avis, rapports |

## Palette de couleurs

Bleu (`#1d4ed8`), Blanc, Violet (`#6d28d9`), Noir (`#0d0620`), Or (`#fbbf24`) —
définis dans `tailwind.config.js`.
