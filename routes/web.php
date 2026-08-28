<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Bailleur;
use App\Http\Controllers\Client;
use App\Http\Controllers\Hotelier;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\LogementController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('accueil');
Route::view('/a-propos', 'a-propos')->name('a-propos');
Route::view('/conditions-utilisation', 'conditions-utilisation')->name('conditions-utilisation');
Route::view('/politique-confidentialite', 'politique-confidentialite')->name('politique-confidentialite');

Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');

Route::get('/logements', [LogementController::class, 'index'])->name('logements.index');
Route::get('/logements/{logement}', [LogementController::class, 'show'])->name('logements.show');

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [LoginController::class, 'create'])->name('login');
    Route::post('/connexion', [LoginController::class, 'store']);
    Route::get('/mot-de-passe-oublie', [LoginController::class, 'forgotPassword'])->name('password.request');
    Route::post('/mot-de-passe-oublie', [LoginController::class, 'findAccount'])->name('password.email');
    Route::post('/mot-de-passe-oublie/confirmer', [LoginController::class, 'resetPassword'])->name('password.reset');
    Route::get('/inscription', [RegisterController::class, 'create'])->name('register');
    Route::post('/inscription', [RegisterController::class, 'store']);
    Route::get('/inscription/verifier', [RegisterController::class, 'formulaireVerification'])->name('register.verifier');
    Route::post('/inscription/verifier', [RegisterController::class, 'verifier'])->name('register.verifier.store');
    Route::post('/inscription/renvoyer-code', [RegisterController::class, 'renvoyerCode'])->name('register.renvoyer-code');
});
Route::post('/deconnexion', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Paiement (AangaraaPay — MTN MoMo / Orange Money)
|--------------------------------------------------------------------------
*/
Route::post('/paiements/webhook', [\App\Http\Controllers\PaiementController::class, 'webhook'])->name('paiements.webhook');

Route::middleware('auth')->prefix('paiements')->name('paiements.')->group(function () {
    Route::get('/{type}/{id}', [\App\Http\Controllers\PaiementController::class, 'formulaire'])->name('formulaire');
    Route::post('/{type}/{id}', [\App\Http\Controllers\PaiementController::class, 'initier'])->name('initier');
    Route::get('/statut/{paiement}', [\App\Http\Controllers\PaiementController::class, 'statut'])->name('statut');
});

/*
|--------------------------------------------------------------------------
| Réservation hôtel + avis + favoris (authentifié, tous rôles connectés)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/chambres/{categorieChambre}/reserver', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/chambres/{categorieChambre}/reserver', [ReservationController::class, 'store'])->name('reservations.store');

    Route::post('/hotels/{hotel}/avis', [Client\AvisController::class, 'store'])->name('avis.store');
    Route::post('/hotels/{hotel}/favori', [Client\FavoriController::class, 'toggle'])->name('favoris.toggle');
    Route::post('/hotels/{hotel}/contacter', [Client\MessageContactController::class, 'contacterHotel'])->name('hotels.contacter');

    Route::post('/logements/{logement}/demande-baye', [Client\DemandeBayeController::class, 'store'])->name('demandes-baye.store');
    Route::post('/logements/{logement}/commentaire', [Client\CommentaireController::class, 'store'])->name('commentaires.store');
    Route::post('/logements/{logement}/contacter', [Client\MessageContactController::class, 'contacterLogement'])->name('logements.contacter');
});

/*
|--------------------------------------------------------------------------
| Notifications dashboard (cloche, tous rôles connectés)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [\App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    Route::post('/{notification}/lue', [\App\Http\Controllers\NotificationController::class, 'marquerLue'])->name('lue');
    Route::post('/tout-lire', [\App\Http\Controllers\NotificationController::class, 'marquerToutesLues'])->name('tout-lire');
});

/*
|--------------------------------------------------------------------------
| Forfaits (hôtelier & bailleur) — essai gratuit, souscription pro
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:hotelier,bailleur'])->prefix('forfait')->name('forfait.')->group(function () {
    Route::get('/', [\App\Http\Controllers\ForfaitController::class, 'index'])->name('index');
    Route::post('/essai', [\App\Http\Controllers\ForfaitController::class, 'demarrerEssai'])->name('essai');
    Route::post('/{forfait}/souscrire', [\App\Http\Controllers\ForfaitController::class, 'souscrire'])->name('souscrire');
});

/*
|--------------------------------------------------------------------------
| Espace Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('actualites', Admin\ActualiteController::class)->except('show');

    Route::get('/hotels', [Admin\HotelValidationController::class, 'index'])->name('hotels.index');
    Route::post('/hotels/{hotel}/approuver', [Admin\HotelValidationController::class, 'approuver'])->name('hotels.approuver');
    Route::post('/hotels/{hotel}/rejeter', [Admin\HotelValidationController::class, 'rejeter'])->name('hotels.rejeter');

    Route::get('/logements', [Admin\LogementValidationController::class, 'index'])->name('logements.index');
    Route::post('/logements/{logement}/approuver', [Admin\LogementValidationController::class, 'approuver'])->name('logements.approuver');
    Route::post('/logements/{logement}/rejeter', [Admin\LogementValidationController::class, 'rejeter'])->name('logements.rejeter');

    // Consultation en lecture seule : l'admin voit tout, ne modifie rien.
    Route::prefix('consultation')->name('consultation.')->group(function () {
        Route::get('/hotels', [Admin\SupervisionController::class, 'hotels'])->name('hotels');
        Route::get('/hotels/{hotel}/chambre/{chambre}', [Admin\SupervisionController::class, 'chambresHotel'])->name('hotels.chambre.show');
        Route::get('/hotels/{hotel}/{action}', [Admin\SupervisionController::class, 'hotel'])->name('hotels.show');
        Route::get('/hotels/{hotel}/{chambre}', [Admin\SupervisionController::class, 'chambresHotel'])->name('hotels.chambre.show');
        Route::get('/logements', [Admin\SupervisionController::class, 'logements'])->name('logements');
        Route::get('/logements/{logement}', [Admin\SupervisionController::class, 'logement'])->name('logements.show');
        Route::get('/bayes', [Admin\SupervisionController::class, 'bayes'])->name('bayes');
        Route::get('/bayes/{baye}', [Admin\SupervisionController::class, 'baye'])->name('bayes.show');
        Route::get('/reservations', [Admin\SupervisionController::class, 'reservations'])->name('reservations');
        Route::get('/reservations/{reservation}', [Admin\SupervisionController::class, 'reservation'])->name('reservations.show');
    });

    Route::get('/utilisateurs', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/utilisateurs/en-attente', [Admin\UserController::class, 'enAttente'])->name('users.en-attente');
    Route::post('/utilisateurs/{user}/valider', [Admin\UserController::class, 'valider'])->name('users.valider');
    Route::post('/utilisateurs/{user}/rejeter', [Admin\UserController::class, 'rejeter'])->name('users.rejeter');
    Route::post('/utilisateurs/{user}/statut', [Admin\UserController::class, 'toggleActif'])->name('users.toggle');
    Route::delete('/utilisateurs/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/avis', [Admin\AvisController::class, 'index'])->name('avis.index');
    Route::post('/avis/{avi}/approuver', [Admin\AvisController::class, 'approuver'])->name('avis.approuver');
    Route::post('/avis/{avi}/rejeter', [Admin\AvisController::class, 'rejeter'])->name('avis.rejeter');

    Route::get('/rapports', [Admin\RapportController::class, 'index'])->name('rapports.index');

    Route::get('/forfaits', [Admin\ForfaitController::class, 'index'])->name('forfaits.index');
    Route::put('/forfaits/{forfait}', [Admin\ForfaitController::class, 'update'])->name('forfaits.update');

    Route::get('/transferts', [Admin\TransfertController::class, 'index'])->name('transferts.index');
    Route::post('/transferts/{transfert}/reessayer', [Admin\TransfertController::class, 'reessayer'])->name('transferts.reessayer');
    Route::post('/transferts/{transfert}/verifier', [Admin\TransfertController::class, 'verifier'])->name('transferts.verifier');
    Route::post('/transferts/{transfert}/effectuer', [Admin\TransfertController::class, 'marquerEffectue'])->name('transferts.effectuer');

    Route::get('/profil', [Admin\ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [Admin\ProfileController::class, 'update'])->name('profil.update');
    Route::post('/contacts-paiement', [Admin\ContactPaiementController::class, 'store'])->name('contacts-paiement.store');
    Route::delete('/contacts-paiement/{contact}', [Admin\ContactPaiementController::class, 'destroy'])->name('contacts-paiement.destroy');

    Route::get('/aide', [Admin\AideController::class, 'index'])->name('aide.index');
});

/*
|--------------------------------------------------------------------------
| Espace Hôtelier
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:hotelier'])->prefix('hotelier')->name('hotelier.')->group(function () {
    Route::get('/', [Hotelier\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('hotels', Hotelier\HotelController::class)->except('show');

    Route::get('/hotels/{hotel}/chambres', [Hotelier\CategorieChambreController::class, 'index'])->name('hotels.chambres.index');
    Route::get('/hotels/{hotel}/chambres/creer', [Hotelier\CategorieChambreController::class, 'create'])->name('hotels.chambres.create');
    Route::post('/hotels/{hotel}/chambres', [Hotelier\CategorieChambreController::class, 'store'])->name('hotels.chambres.store');
    Route::get('/hotels/{hotel}/chambres/{chambre}/modifier', [Hotelier\CategorieChambreController::class, 'edit'])->name('hotels.chambres.edit');
    Route::put('/hotels/{hotel}/chambres/{chambre}', [Hotelier\CategorieChambreController::class, 'update'])->name('hotels.chambres.update');
    Route::delete('/hotels/{hotel}/chambres/{chambre}', [Hotelier\CategorieChambreController::class, 'destroy'])->name('hotels.chambres.destroy');

    Route::post('/galerie/{type}/{id}', [Hotelier\PhotoController::class, 'store'])->name('photos.store');
    Route::delete('/galerie/{photo}', [Hotelier\PhotoController::class, 'destroy'])->name('photos.destroy');

    Route::get('/reservations', [Hotelier\ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations/{reservation}/confirmer', [Hotelier\ReservationController::class, 'confirmer'])->name('reservations.confirmer');
    Route::post('/reservations/{reservation}/annuler', [Hotelier\ReservationController::class, 'annuler'])->name('reservations.annuler');

    Route::get('/avis', [Hotelier\AvisController::class, 'index'])->name('avis.index');

    Route::get('/messages', [Hotelier\MessageContactController::class, 'index'])->name('messages.index');

    Route::get('/profil', [Hotelier\ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [Hotelier\ProfileController::class, 'update'])->name('profil.update');

    Route::post('/hotels/{hotel}/contacts-paiement', [Hotelier\ContactPaiementController::class, 'store'])->name('contacts-paiement.store');
    Route::delete('/hotels/{hotel}/contacts-paiement/{contact}', [Hotelier\ContactPaiementController::class, 'destroy'])->name('contacts-paiement.destroy');

    Route::post('/hotels/{hotel}/reseaux-sociaux', [Hotelier\ReseauSocialController::class, 'store'])->name('reseaux-sociaux.store');
    Route::delete('/hotels/{hotel}/reseaux-sociaux/{reseau}', [Hotelier\ReseauSocialController::class, 'destroy'])->name('reseaux-sociaux.destroy');

    Route::get('/aide', [Hotelier\AideController::class, 'index'])->name('aide.index');
});

/*
|--------------------------------------------------------------------------
| Espace Client
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:client'])->prefix('mon-espace')->name('client.')->group(function () {
    Route::get('/reservations', [Client\ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}/suivi', [Client\ReservationController::class, 'suivi'])->name('reservations.suivi');

    Route::get('/favoris', [Client\FavoriController::class, 'index'])->name('favoris.index');

    Route::get('/profil', [Client\ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [Client\ProfileController::class, 'update'])->name('profil.update');

    Route::get('/locations', [Client\BayeController::class, 'index'])->name('bayes.index');
    Route::get('/locations/{baye}', [Client\BayeController::class, 'show'])->name('bayes.show');
    Route::post('/locations/{baye}/prolonger', [Client\BayeController::class, 'demanderProlongation'])->name('bayes.prolonger');

    Route::get('/loyers/{loyer}/payer', [Client\LoyerController::class, 'payer'])->name('loyers.payer');

    Route::get('/aide', [Client\AideController::class, 'index'])->name('aide.index');
});

/*
|--------------------------------------------------------------------------
| Espace Bailleur
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:bailleur'])->prefix('bailleur')->name('bailleur.')->group(function () {
    Route::get('/', [Bailleur\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('minicites', Bailleur\MiniciteController::class)->except('show');
    Route::resource('logements', Bailleur\LogementController::class)->except('show');

    Route::post('/galerie/{type}/{id}', [Bailleur\PhotoController::class, 'store'])->name('photos.store');
    Route::delete('/galerie/{photo}', [Bailleur\PhotoController::class, 'destroy'])->name('photos.destroy');

    Route::get('/demandes', [Bailleur\DemandeBayeController::class, 'index'])->name('demandes.index');
    Route::post('/demandes/{demande}/valider', [Bailleur\DemandeBayeController::class, 'valider'])->name('demandes.valider');
    Route::post('/demandes/{demande}/rejeter', [Bailleur\DemandeBayeController::class, 'rejeter'])->name('demandes.rejeter');

    Route::get('/locations', [Bailleur\BayeController::class, 'index'])->name('bayes.index');
    Route::post('/prolongations/{prolongation}/approuver', [Bailleur\BayeController::class, 'approuverProlongation'])->name('prolongations.approuver');

    Route::get('/logements/{logement}/clients', [Bailleur\ClientController::class, 'parLogement'])->name('logements.clients');

    Route::get('/commentaires', [Bailleur\CommentaireController::class, 'index'])->name('commentaires.index');

    Route::get('/messages', [Bailleur\MessageContactController::class, 'index'])->name('messages.index');

    Route::get('/profil', [Bailleur\ProfileController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [Bailleur\ProfileController::class, 'update'])->name('profil.update');

    Route::post('/contacts-paiement', [Bailleur\ContactPaiementController::class, 'store'])->name('contacts-paiement.store');
    Route::delete('/contacts-paiement/{contact}', [Bailleur\ContactPaiementController::class, 'destroy'])->name('contacts-paiement.destroy');

    Route::get('/aide', [Bailleur\AideController::class, 'index'])->name('aide.index');
});
