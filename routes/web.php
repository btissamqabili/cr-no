<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CreneauController;
use App\Http\Controllers\Admin\DashboardController;

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
Route::middleware('auth')->prefix('client')->name('client.')->group(function () {
    Route::get('/creneaux', [App\Http\Controllers\Client\ReservationController::class, 'index'])->name('creneaux');
    Route::post('/reserver', [App\Http\Controllers\Client\ReservationController::class, 'store'])->name('reserver');
    Route::get('/mes-rdv', [App\Http\Controllers\Client\ReservationController::class, 'mesRendezVous'])->name('mes-rdv');
    Route::delete('/annuler/{rendezVous}', [App\Http\Controllers\Client\ReservationController::class, 'cancel'])->name('annuler');
});

// ===== ROUTES ADMIN (protégées) =====
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Plus tard on ajoutera ici le CRUD des créneaux
  Route::resource('creneaux', CreneauController::class)
    ->parameters(['creneaux' => 'creneau']);
});

require __DIR__.'/auth.php';