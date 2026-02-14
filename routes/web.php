<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReuseController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ReportsController;

Route::get('/', fn() => view('welcome'))->name('welcome');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/informative', fn() => view('informative'))->name('informative');

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/reuse', [ReuseController::class, 'index'])->name('reuse.index');
    Route::get('/reuse/medications', [DonationsController::class, 'availableMedications'])->name('reuse.medications');
    Route::get('/reuse/doacoes', [DonationsController::class, 'index'])->name('reuse.doacoes');

    Route::get('/pontos-coleta', [MapController::class, 'index'])->name('pontos.coleta');

    Route::get('/medicamentos/doacao', [MedicationController::class, 'doacao'])->name('medications.doacao');

    Route::prefix('reports')->group(function () {
        Route::get('/medications', [ReportsController::class, 'medications'])->name('reports.medications');
        Route::get('/donations', [ReportsController::class, 'donations'])->name('reports.donations');
    });

    Route::middleware(['admin'])->group(function () {

        Route::resource('medications', MedicationController::class)->except(['show']);

        Route::get('/medications/create-donation', [MedicationController::class, 'createDonation'])
            ->name('medications.createDonation');

        Route::prefix('reuse/doacoes')->group(function () {
            Route::get('/create', [DonationsController::class, 'create'])->name('reuse.doacoes.create');
            Route::post('/', [DonationsController::class, 'store'])->name('reuse.doacoes.store');
            Route::get('/{id}/edit', [DonationsController::class, 'edit'])->name('reuse.doacoes.edit');
            Route::put('/{id}', [DonationsController::class, 'update'])->name('reuse.doacoes.update');
            Route::delete('/{id}', [DonationsController::class, 'destroy'])->name('reuse.doacoes.destroy');
            Route::put('/{id}/confirm', [DonationsController::class, 'confirm'])->name('reuse.doacoes.confirm');
            Route::put('/{id}/cancel', [DonationsController::class, 'cancel'])->name('reuse.doacoes.cancel');
        });
    });
});
