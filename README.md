# Flux — Plateforme de réservation hôtelière & de mise en relation locative

Application Laravel complète : modèle de données, contrôleurs, vues responsives, workflows métier (validation, paiement, moratoire), e-mails transactionnels et fichiers d'environnement.

## 1. Fonctionnalités livrées

### Comptes & validation
- **Inscription en deux étapes** : informations → code de vérification à 6 chiffres envoyé par e-mail → activation. Seuls les **clients sont actifs par défaut** ; hôteliers et bailleurs passent en attente de validation admin après vérification de leur e-mail.
- L'admin reçoit un e-mail à chaque nouvelle inscription hôtelier/bailleur, chaque nouvel hôtel et chaque nouveau logement soumis. La personne concernée reçoit un e-mail de validation ou de rejet (avec motif), et peut se reconnecter ou soumettre une nouvelle demande en conséquence.
- Toute modification d'un hôtel ou d'un logement le repasse automatiquement en attente de validation.

### Réservations & paiement
- Formulaire de réservation avec **coût total calculé en direct** (Alpine.js) selon les dates choisies.
- Paiement **MTN MoMo / Orange Money** via l'API [aangaraa-pay.com](https://aangaraa-pay.com/integrate-aangaraa-pay) : `App\Services\AangaraaPayService` (paiement direct, détection automatique de l'opérateur, vérification de statut), `PaiementController` (formulaire, initiation, polling temps réel, webhook).
- À la fin d'un séjour (tâche planifiée quotidienne) : e-mail à l'hôtelier, **pro-forma PDF** généré et envoyé au client, téléchargeable aussi depuis son espace et par l'admin en consultation.

### Location de logements
- Le client choisit une **durée personnalisée** (≥ durée minimum du logement) en contactant le bailleur.
- À la validation de la demande : **paiement initial obligatoire** (caution + durée minimum) généré comme une seule échéance ; les mois suivants sont des mensualités que le client règle **à son rythme** (fin de mois, tous les deux mois...) depuis son espace.
- **Moratoire** : délai (7 jours par défaut, modifiable par logement) après la fin du bail avant que le logement redevienne visible sur le site — le temps de le libérer ou de valider une prolongation. Les prolongations doivent être **validées par le bailleur**.
- À l'expiration du bail (moratoire inclus, tâche planifiée) : logement remis en ligne automatiquement, e-mail au bailleur, pro-forma PDF envoyé au client.
- **Villas toujours meublées** : forcé côté modèle (mutateur Eloquent) quel que soit ce qui est soumis.

### Consultation admin (lecture seule)
- L'admin a accès à **toutes** les informations des hôtels, logements, baux et réservations (`Admin\SupervisionController`, listes filtrées + détail) **sans pouvoir les modifier** — la gestion reste entre les mains de l'hôtelier/bailleur/client concerné.

### Interface
- **Carrousel d'actualités** intégré au hero de l'accueil (Alpine.js, transition fondu, puces, flèches, rotation automatique toutes les 6s).
- **Filtres pertinents sur toutes les ressources listées des dashboards** : statut, ville, type, note, période, validation... (voir tableau ci-dessous).
- **Guide & notice** dans chaque espace (admin, hôtelier, client, bailleur) expliquant les workflows propres au rôle.

| Espace | Ressource | Filtres |
|---|---|---|
| Admin | Utilisateurs | rôle, statut de validation, recherche |
| Admin | Actualités | période (en cours / à venir / passées) |
| Admin | Avis | note minimum |
| Admin | Consultation hôtels | statut, ville |
| Admin | Consultation logements | validation, type |
| Admin | Consultation baux | statut |
| Admin | Consultation réservations | statut |
| Hôtelier | Hôtels | statut de validation |
| Hôtelier | Chambres | recherche par nom |
| Hôtelier | Réservations | statut |
| Hôtelier | Avis | hôtel, note minimum |
| Bailleur | Logements | type, validation, disponibilité |
| Bailleur | Mini-cités | ville |
| Bailleur | Demandes de baye | statut |
| Bailleur | Locations | statut |
| Bailleur | Commentaires | logement, note minimum |
| Client | Réservations | statut (onglets) |
| Client | Favoris | ville |
| Client | Locations | statut (onglets) |

## 2. Nouveaux fichiers clés

```
app/Services/AangaraaPayService.php       Client API paiement (doc officielle)
app/Services/ProformaService.php          Génération des PDF pro-forma (dompdf)
app/Http/Controllers/PaiementController.php   Formulaire / initiation / webhook / statut
app/Mail/ (14 classes)                    E-mails transactionnels (code, validations, pro-forma...)
resources/views/mail/ (14 vues)           Templates markdown (composant natif Laravel)
resources/views/pdf/                      Templates des pro-forma PDF
app/Console/Commands/
  TerminerSejoursExpires.php              Clôture des séjours + e-mails + PDF (quotidien)
  TraiterBauxExpires.php                  Libération des logements après moratoire (quotidien)
routes/console.php                        Planification des deux commandes ci-dessus
app/Http/Controllers/Admin/
  SupervisionController.php               Consultation lecture seule (hôtels/logements/baux/résa)
  LogementValidationController.php        Validation admin des logements
  AideController.php (+ Hotelier/Client/Bailleur)   Guide & notice par espace
```

## 3. Démarrage

```bash
composer install
cp .env.example .env
php artisan key:generate

# configure DB_*, MAIL_*, AANGARAA_PAY_* dans .env
php artisan migrate --seed
php artisan storage:link

npm install && npm run dev   # terminal 1
php artisan serve            # terminal 2
php artisan schedule:work    # terminal 3 — indispensable pour les clôtures automatiques
```

**Compte admin** (créé par le seeder) : `admin@flux.cm` / `password`.

## 4. Variables d'environnement à renseigner

- `MAIL_*` — indispensable : toute la mécanique de validation de compte, d'hôtel, de logement et les pro-forma passent par e-mail.
- `AANGARAA_PAY_APP_KEY` — clé fournie par aangaraa-pay.com. Voir `config/services.php` et [la documentation officielle](https://aangaraa-pay.com/integrate-aangaraa-pay).

## 5. TODO restants

- Le webhook (`/paiements/webhook`) doit être accessible publiquement (pas de HTTPS local ? utiliser ngrok/expose en développement pour le tester réellement).
- Notification par mail/SMS supplémentaire lors d'une demande de baye reçue par le bailleur (actuellement visible uniquement dans son espace).
- Les tâches planifiées nécessitent `php artisan schedule:work` (dev) ou une entrée cron `* * * * * php artisan schedule:run` (production) — sans cela, séjours et baux ne se clôturent jamais automatiquement.
