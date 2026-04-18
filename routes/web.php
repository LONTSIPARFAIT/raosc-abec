<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return inertia('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'categories' => \App\Http\Resources\OrganizationCategoryResource::collection(\App\Models\OrganizationCategory::all())->resolve(),
        'organizations' => \App\Http\Resources\OrganizationResource::collection(\App\Models\Organization::with('categories')->where('status', 'approved')->latest()->take(4)->get())->resolve(),
        'stats' => [
            'organizations_count' => \App\Models\Organization::where('status', 'approved')->count(),
            'categories_count' => \App\Models\OrganizationCategory::count(),
            'projects_count' => \App\Models\Project::count(),
            'countries_count' => \App\Models\Organization::where('status', 'approved')->distinct('country')->count('country'),
        ],
        'recentNews' => \App\Http\Resources\PostResource::collection(\App\Models\Post::with('organization')->latest()->take(3)->get())->resolve()
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Notifications
    Route::get('dashboard/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::put('dashboard/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::put('dashboard/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    // Projets & Bénévolat
    Route::get('dashboard/projects', [\App\Http\Controllers\Dashboard\ProjectController::class, 'index'])->name('projects.index');
    Route::post('dashboard/projects', [\App\Http\Controllers\Dashboard\ProjectController::class, 'store'])->name('projects.store');
    Route::delete('dashboard/projects/{project}', [\App\Http\Controllers\Dashboard\ProjectController::class, 'destroy'])->name('projects.destroy');

    // Actualités (gestion par les orgs)
    Route::get('dashboard/posts', [\App\Http\Controllers\PostController::class, 'dashboard'])->name('dashboard.posts.index');
    Route::post('dashboard/posts', [\App\Http\Controllers\PostController::class, 'store'])->name('dashboard.posts.store');
    Route::delete('dashboard/posts/{post}', [\App\Http\Controllers\PostController::class, 'destroy'])->name('dashboard.posts.destroy');
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
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/organizations', [\App\Http\Controllers\Admin\OrganizationManagementController::class, 'index'])->name('organizations.index');
    Route::post('/organizations/{organization}/status', [\App\Http\Controllers\Admin\OrganizationManagementController::class, 'updateStatus'])->name('organizations.status');
    
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    
    // Catégories
    Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/coming-soon', function() { return inertia('Admin/ComingSoon'); })->name('coming-soon');
});

// Autres pages publiques
Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts');
Route::get('/posts/{slug}', [\App\Http\Controllers\PostController::class, 'show'])->name('posts.show');
Route::get('/about', function() { return inertia('About'); })->name('about');
Route::get('/contact', function() { return inertia('Contact'); })->name('contact');
Route::get('/community', function() { return inertia('Community'); })->name('community');

// Pages de politique
Route::get('/privacy', function() { return inertia('Legal/Privacy'); })->name('privacy');
Route::get('/terms', function() { return inertia('Legal/Terms'); })->name('terms');
Route::get('/cookies', function() { return inertia('Legal/Cookies'); })->name('cookies');

require __DIR__.'/settings.php';
