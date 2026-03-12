<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return inertia('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'organizations' => \App\Models\Organization::with('categories')->latest()->take(3)->get(),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

// Routes publiques RAO
Route::prefix('rao')->name('rao.')->group(function () {
    Route::get('/', [\App\Http\Controllers\RaoController::class, 'index'])->name('index');
    Route::get('/orga/{slug}', [\App\Http\Controllers\RaoController::class, 'show'])->name('show');
    
    // Espace de création (protégé)
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/join', [\App\Http\Controllers\RaoController::class, 'create'])->name('create');
        Route::post('/join', [\App\Http\Controllers\RaoController::class, 'store'])->name('store');
    });
});

require __DIR__.'/settings.php';
