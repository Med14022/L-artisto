<?php

use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminRendezVousController;
use App\Http\Controllers\coiffeur\CoiffeurDashboardController;
use App\Http\Controllers\client\DashboardController;
use App\Http\Controllers\Coiffeur\CoifDashboardController;
use App\Http\Controllers\HoraireController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RendezVousController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// ─── Réservation publique (sans compte) ───────────────────────────────────────
Route::get('/reserver', [\App\Http\Controllers\PublicReservationController::class, 'index'])->name('reserver');
Route::post('/reserver', [\App\Http\Controllers\PublicReservationController::class, 'store'])->name('reserver.store');
Route::get('/reserver/merci', [\App\Http\Controllers\PublicReservationController::class, 'confirmation'])->name('reserver.confirmation');

// ─── Routes Client ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rendez-vous
    Route::post('/rendez-vous', [RendezVousController::class, 'store'])->name('rendez-vous.store');
    Route::delete('/rendez-vous/{rendezVous}', [RendezVousController::class, 'destroy'])->name('rendez-vous.destroy');
    Route::get('/rendez-vous/available-times', [RendezVousController::class, 'availableTimes'])->name('rendez-vous.available-times');
});

// ─── Routes Profil ───────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Routes Admin ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('services', ServiceController::class);

    // Gestion des clients
    Route::get('/clients', [\App\Http\Controllers\admin\AdminClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/{user}', [\App\Http\Controllers\admin\AdminClientController::class, 'show'])->name('clients.show');

    // Gestion des horaires coiffeurs
    Route::get('/horaires', [\App\Http\Controllers\admin\AdminHoraireController::class, 'index'])->name('horaires.index');
    Route::post('/horaires', [\App\Http\Controllers\admin\AdminHoraireController::class, 'store'])->name('horaires.store');
    Route::patch('/horaires/{horaire}', [\App\Http\Controllers\admin\AdminHoraireController::class, 'update'])->name('horaires.update');
    Route::delete('/horaires/{horaire}', [\App\Http\Controllers\admin\AdminHoraireController::class, 'destroy'])->name('horaires.destroy');

    // Gestion des rendez-vous
    Route::get('/rendez-vous', [AdminRendezVousController::class, 'index'])->name('rendez-vous.index');
    Route::get('/rendez-vous/create', [AdminRendezVousController::class, 'create'])->name('rendez-vous.create');
    Route::post('/rendez-vous', [AdminRendezVousController::class, 'store'])->name('rendez-vous.store');
    Route::patch('/rendez-vous/{rendezVous}/status', [AdminRendezVousController::class, 'updateStatus'])->name('rendez-vous.update-status');
    Route::delete('/rendez-vous/{rendezVous}', [AdminRendezVousController::class, 'destroy'])->name('rendez-vous.destroy');
});

// ─── Routes Coiffeur ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'isCoiffeur'])->prefix('coiffeur')->name('coiffeur.')->group(function () {
    Route::get('/dashboard', [CoiffeurDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/rendez-vous/{rendezVous}/status', [CoiffeurDashboardController::class, 'updateStatus'])->name('rendez-vous.update-status');
});

// ─── Routes Legacy (CoifDash / Horaire) ───────────────────────────────────────
Route::post('/horaire/days', [DashboardController::class, 'getWorkingDays'])->name('horaire.days');
Route::post('coiffeur/days', [HoraireController::class, 'days'])->name('horaire.coiffeur-days');
Route::post('coiffeur/hours', [HoraireController::class, 'hours'])->name('horaire.hours');

Route::post('/reservation', [DashboardController::class, 'store'])
    ->middleware('auth')
    ->name('reservation');

Route::get('/coifdash', [CoifDashboardController::class, 'index'])->name('coifdash');

Route::post('/coiffeur/rdv_par_date', [CoifDashboardController::class, 'rdv_par_date']);

Route::post('coiffeur/rdv_guest', [CoifDashboardController::class, 'storeGuest'])
    ->name('coifdash.rdv_guest');

require __DIR__ . '/auth.php';
