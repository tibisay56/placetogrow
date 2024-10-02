<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SubscriptionController;
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
    Route::get('sites/{slug}/transactions', [SiteController::class, 'showTransactions'])->name('site.transactions.show');
    Route::get('sites/{site}/edit', [SiteController::class, 'edit'])->name('site.edit');
    Route::post('sites/{site}', [SiteController::class, 'update'])->name('site.update');
    Route::delete('sites/{site}', [SiteController::class, 'destroy'])->name('site.destroy');
});
Route::prefix('dashboard')->group(function () {
    Route::get('sites/{slug}', [SiteController::class, 'showBySlug'])->name('site.show.slug');
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

//Payment
Route::prefix('dashboard')->group(function () {
    Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payment.show');
    Route::get('payments', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('payments/create', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('payment/form/{siteId}', [PaymentController::class, 'form'])->name('payment.form');
});

//Plans
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('plans', [PlanController::class, 'index'])->name('plan.index');
    Route::get('plans/create', [PlanController::class, 'create'])->name('plan.create');
    Route::post('plans', [PlanController::class, 'store'])->name('plan.store');
    Route::get('plans/{plan}', [PlanController::class, 'show'])->name('plan.show');
    Route::get('plans/{plan}/edit', [PlanController::class, 'edit'])->name('plan.edit');
    Route::put('plans/{plan}', [PlanController::class, 'update'])->name('plan.update');
    Route::delete('plans/{plan}', [PlanController::class, 'destroy'])->name('plan.destroy');
});
//Subscription
Route::prefix('dashboard')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscription.index');
        Route::delete('subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscription.destroy');
    });

    Route::get('subscription/create/{siteId}', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::get('subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::get('/plan', [SubscriptionController::class, 'plan'])->name('plan');
    Route::post('subscriptions', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::get('/return/{subscription}', [SubscriptionController::class, 'return'])->name('subscription.return');
});

//Import
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('imports', [ImportController::class, 'index'])->name('import.index');
    Route::get('imports/create', [ImportController::class, 'create'])->name('import.create');
    Route::post('imports', [ImportController::class, 'store'])->name('import.store');
    Route::get('imports/{import}', [ImportController::class, 'show'])->name('import.show');
    Route::get('imports/{import}/edit', [ImportController::class, 'edit'])->name('import.edit');
    Route::put('imports/{import}', [ImportController::class, 'update'])->name('import.update');
    Route::delete('imports/{import}', [ImportController::class, 'destroy'])->name('import.destroy');
});

//Invoice
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('invoices', [ImportController::class, 'store'])->name('invoice.store');
});

//Lang
Route::get('/language/{language}', function ($language) {
    Session::put('locale', $language);

    return redirect()->back();
})->name('language');

require __DIR__.'/auth.php';
