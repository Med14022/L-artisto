<?php

use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\client\Dashboard;
use App\Http\Controllers\client\DashboardController;
use App\Http\Controllers\HoraireController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/horaire/days', [DashboardController::class, 'getWorkingDays'])->name('horaire.days');
Route::post('/horaire/hours', [HoraireController::class, 'hours'])->name('horaire.hours');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth') // si tu veux protéger l'accès
    ->name('home');

Route::post('/reservation', [DashboardController::class, 'store'])
    ->middleware('auth') // si tu veux protéger l'accès
    ->name('reservation');

require __DIR__ . '/auth.php';
