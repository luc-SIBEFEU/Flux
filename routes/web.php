<?php

use App\Http\Controllers\Admin\ActualiteController as AdminActualiteController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HotelValidationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\FavoriController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\Client\ReservationController as ClientReservationController;
use App\Http\Controllers\Client\ReviewController as ClientReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Hotelier\DashboardController as HotelierDashboardController;
use App\Http\Controllers\Hotelier\HotelController as HotelierHotelController;
use App\Http\Controllers\Hotelier\HotelGalleryController;
use App\Http\Controllers\Hotelier\PaymentContactController;
use App\Http\Controllers\Hotelier\ProfileController as HotelierProfileController;
use App\Http\Controllers\Hotelier\ReservationController as HotelierReservationController;
use App\Http\Controllers\Hotelier\RoomCategoryController;
use App\Http\Controllers\Hotelier\RoomGalleryController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [LoginController::class, 'create'])->name('login');
    Route::post('/connexion', [LoginController::class, 'store']);
    Route::get('/inscription', [RegisterController::class, 'create'])->name('register');
    Route::post('/inscription', [RegisterController::class, 'store']);
});

Route::post('/deconnexion', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Réservation & favoris (client connecté uniquement)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/reservations/creer', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    Route::get('/paiement/{payment}/instructions', [PaymentController::class, 'instructions'])->name('paiement.instructions');
    Route::post('/paiement/{payment}/preuve', [PaymentController::class, 'soumettrePreuve'])->name('paiement.preuve');
    Route::post('/paiement/{payment}/verifier', [PaymentController::class, 'verifier'])->name('paiement.verifier');

    Route::post('/hotels/{hotel}/favori', [HotelController::class, 'basculerFavori'])->name('hotels.favori');

    Route::get('/mon-profil', [ClientProfileController::class, 'edit'])->name('client.profile.edit');
    Route::put('/mon-profil', [ClientProfileController::class, 'update'])->name('client.profile.update');
    Route::put('/mon-profil/mot-de-passe', [ClientProfileController::class, 'updatePassword'])->name('client.profile.password');

    Route::get('/mes-reservations', [ClientReservationController::class, 'index'])->name('client.reservations.index');
    Route::put('/mes-reservations/{reservation}/annuler', [ClientReservationController::class, 'annuler'])->name('client.reservations.annuler');

    Route::get('/mes-favoris', [FavoriController::class, 'index'])->name('client.favoris');
    Route::delete('/mes-favoris/{hotelId}', [FavoriController::class, 'destroy'])->name('client.favoris.destroy');

    Route::get('/hotels/{hotel}/avis', [ClientReviewController::class, 'create'])->name('client.reviews.create');
    Route::post('/hotels/{hotel}/avis', [ClientReviewController::class, 'store'])->name('client.reviews.store');
});

/*
|--------------------------------------------------------------------------
| Espace Hôtelier
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:hotelier'])->prefix('hotelier')->name('hotelier.')->group(function () {
    Route::get('/', [HotelierDashboardController::class, 'index'])->name('dashboard');

    Route::resource('hotels', HotelierHotelController::class)->except(['show']);

    Route::get('hotels/{hotel}/chambres', [RoomCategoryController::class, 'index'])->name('rooms.index');
    Route::get('hotels/{hotel}/chambres/creer', [RoomCategoryController::class, 'create'])->name('rooms.create');
    Route::post('hotels/{hotel}/chambres', [RoomCategoryController::class, 'store'])->name('rooms.store');
    Route::get('hotels/{hotel}/chambres/{chambre}/modifier', [RoomCategoryController::class, 'edit'])->name('rooms.edit');
    Route::put('hotels/{hotel}/chambres/{chambre}', [RoomCategoryController::class, 'update'])->name('rooms.update');
    Route::delete('hotels/{hotel}/chambres/{chambre}', [RoomCategoryController::class, 'destroy'])->name('rooms.destroy');

    Route::get('hotels/{hotel}/galerie', [HotelGalleryController::class, 'index'])->name('gallery.index');
    Route::post('hotels/{hotel}/galerie', [HotelGalleryController::class, 'store'])->name('gallery.store');
    Route::delete('hotels/{hotel}/galerie/{image}', [HotelGalleryController::class, 'destroy'])->name('gallery.destroy');

    Route::get('chambres/{chambre}/galerie', [RoomGalleryController::class, 'index'])->name('rooms.gallery.index');
    Route::post('chambres/{chambre}/galerie', [RoomGalleryController::class, 'store'])->name('rooms.gallery.store');
    Route::delete('chambres/{chambre}/galerie/{image}', [RoomGalleryController::class, 'destroy'])->name('rooms.gallery.destroy');

    Route::get('/reservations', [HotelierReservationController::class, 'index'])->name('reservations.index');
    Route::put('/reservations/{reservation}/confirmer-paiement', [HotelierReservationController::class, 'confirmerPaiement'])->name('reservations.confirmer-paiement');

    Route::get('/contacts-paiement', [PaymentContactController::class, 'edit'])->name('payment-contacts.edit');
    Route::put('/contacts-paiement', [PaymentContactController::class, 'update'])->name('payment-contacts.update');

    Route::get('/profil', [HotelierProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [HotelierProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/mot-de-passe', [HotelierProfileController::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Espace Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('actualites', AdminActualiteController::class)->except(['show']);

    Route::get('/hotels/validation', [HotelValidationController::class, 'index'])->name('hotels.validation');
    Route::put('/hotels/{hotel}/valider', [HotelValidationController::class, 'valider'])->name('hotels.valider');
    Route::put('/hotels/{hotel}/rejeter', [HotelValidationController::class, 'rejeter'])->name('hotels.rejeter');

    Route::get('/utilisateurs', [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/utilisateurs/{user}/basculer', [AdminUserController::class, 'basculerActivation'])->name('users.toggle');
    Route::delete('/utilisateurs/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/avis', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::put('/avis/{review}/approuver', [AdminReviewController::class, 'approuver'])->name('reviews.approuver');
    Route::put('/avis/{review}/rejeter', [AdminReviewController::class, 'rejeter'])->name('reviews.rejeter');

    Route::get('/rapports', [ReportController::class, 'index'])->name('reports');
});

/*
|--------------------------------------------------------------------------
| Retour et webhook Orange Money (API officielle)
|--------------------------------------------------------------------------
| Ces routes sont appelées par Orange (redirection du client ou notification
| serveur-à-serveur) : elles doivent rester accessibles sans authentification.
*/
Route::get('/paiement/orange/retour/{payment}', [PaymentController::class, 'retourOrange'])->name('paiement.orange.retour');
Route::get('/paiement/orange/annulation/{payment}', [PaymentController::class, 'annulationOrange'])->name('paiement.orange.annulation');
Route::post('/paiement/webhook/orange', [PaymentController::class, 'webhookOrange'])->name('paiement.webhook.orange');
