<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', WelcomeController::class)->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//User
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('user.index');
    Route::get('users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('users/create', [UserController::class, 'store'])->name('user.store');
    Route::get('users/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

//Sites
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('sites', [SiteController::class, 'index'])->name('site.index');
    Route::get('sites/create', [SiteController::class, 'create'])->name('site.create');
    Route::post('sites', [SiteController::class, 'store'])->name('site.store');
    Route::get('sites/{site}', [SiteController::class, 'show'])->name('site.show');
    Route::get('sites/{site}/edit', [SiteController::class, 'edit'])->name('site.edit');
    Route::post('sites/{site}', [SiteController::class, 'update'])->name('site.update');
    Route::delete('sites/{site}', [SiteController::class, 'destroy'])->name('site.destroy');
});

//Role
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('roles/create', [RoleController::class, 'store'])->name('role.store');
    Route::get('roles/{role}', [RoleController::class, 'show'])->name('role.show');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::patch('roles/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('role.destroy');
});

//Form
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('forms', [FormController::class, 'index'])->name('form.index');
    Route::get('forms/create', [FormController::class, 'create'])->name('form.create');
    Route::post('forms', [FormController::class, 'store'])->name('form.store');
    Route::get('forms/{form}', [FormController::class, 'show'])->name('form.show');
    Route::get('forms/{form}/edit', [FormController::class, 'edit'])->name('form.edit');
    Route::post('forms/{form}', [FormController::class, 'update'])->name('form.update');
    Route::delete('forms/{form}', [FormController::class, 'destroy'])->name('form.destroy');
});

//Payment
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('settings', SettingsController::class);
});

Route::prefix('dashboard')->group(function () {
    Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payment.show');
    Route::get('payments', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('payments/create', [PaymentController::class, 'store'])->name('payment.store');
});
//Admin
Route::get('/admin/register', [AdminController::class, 'create'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'store']);

//Lang
Route::get('/language/{language}', function ($language) {
    Session::put('locale', $language);
    return redirect()->back();
})->name('language');

require __DIR__.'/auth.php';
