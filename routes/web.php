<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return inertia('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'organizations' => \App\Models\Organization::with('categories')->where('status', 'approved')->latest()->take(3)->get(),
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

// Autres pages publiques
Route::get('/posts', function() { return inertia('Posts'); })->name('posts');
Route::get('/about', function() { return inertia('About'); })->name('about');
Route::get('/contact', function() { return inertia('Contact'); })->name('contact');
Route::get('/community', function() { return inertia('Community'); })->name('community');

// Pages de politique
Route::get('/privacy', function() { return inertia('Legal/Privacy'); })->name('privacy');
Route::get('/terms', function() { return inertia('Legal/Terms'); })->name('terms');
Route::get('/cookies', function() { return inertia('Legal/Cookies'); })->name('cookies');

require __DIR__.'/settings.php';
