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
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Notifications
    Route::get('dashboard/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::put('dashboard/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::put('dashboard/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

// Routes publiques RAO
Route::prefix('rao')->name('rao.')->group(function () {
    Route::get('/', [\App\Http\Controllers\RaoController::class, 'index'])->name('index');
    Route::get('/orga/{slug}', [\App\Http\Controllers\RaoController::class, 'show'])->name('show');
    
    // Espace de création et édition (protégé)
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/join', [\App\Http\Controllers\RaoController::class, 'create'])->name('create');
        Route::post('/join', [\App\Http\Controllers\RaoController::class, 'store'])->name('store');
        Route::get('/mes-structures', [\App\Http\Controllers\RaoController::class, 'myOrganizations'])->name('my-organizations');
        Route::get('/orga/{organization:slug}/edit', [\App\Http\Controllers\RaoController::class, 'edit'])->name('edit');
        Route::put('/orga/{organization:slug}', [\App\Http\Controllers\RaoController::class, 'update'])->name('update');
    });
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/organizations/{organization}/status', [\App\Http\Controllers\Admin\OrganizationManagementController::class, 'updateStatus'])->name('organizations.status');
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
