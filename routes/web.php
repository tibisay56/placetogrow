<?php

use App\Http\Controllers\LangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Users
Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::get('users/create', [UserController::class, 'create'])->name('site.create');
    Route::post('users/create', [UserController::class, 'store'])->name('site.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('site.edit');
    Route::patch('users/{user}', [UserController::class, 'update'])->name('site.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('site.destroy');
});

//Sites
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('sites', [SiteController::class, 'index'])->name('site.index');
    Route::get('sites/create', [SiteController::class, 'create'])->name('site.create');
    Route::post('sites/create', [SiteController::class, 'store'])->name('site.store');
    Route::get('sites/{site}', [SiteController::class, 'show'])->name('site.show');
    Route::get('sites/{site}/edit', [siteController::class, 'edit'])->name('site.edit');
    Route::post('sites/{site}', [SiteController::class, 'update'])->name('site.update');
    Route::delete('sites/{site}', [SiteController::class, 'destroy'])->name('site.destroy');
});

//Roles
Route::prefix('role')->middleware('auth')->group(function () {
    Route::get('roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('roles/create', [RoleController::class, 'create'])->name('role.store');
    Route::post('roles/{role}', [RoleController::class, 'create'])->name('role.show');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::patch('roles/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('role.destroy');
});



//Lang
Route::get('lang/{locale}', [LangController::class, 'change'])->name('changeLang');

require __DIR__.'/auth.php';
