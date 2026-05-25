<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\PensionSchemeController;
use App\Http\Controllers\CitizenPensionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DuplicateDetectionController;

// Auth Routes
Auth::routes();

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'dashboard'])->name('home');

    // Profile (User)
    Route::get('/profile/create', [App\Http\Controllers\ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store');

    // Schemes (User)
    Route::get('/user/schemes', [App\Http\Controllers\UserSchemeController::class, 'index'])->name('user.schemes.index');
    Route::get('/user/schemes/{scheme}/apply', [App\Http\Controllers\UserSchemeController::class, 'apply'])->name('user.schemes.apply');
    Route::post('/user/schemes/{scheme}/apply', [App\Http\Controllers\UserSchemeController::class, 'storeApplication'])->name('citizen.application.store');

    // User Portal (Transactions, Certificates, Support)
    Route::get('/user/transactions', [App\Http\Controllers\UserPortalController::class, 'transactions'])->name('user.transactions.index');
    Route::get('/user/certificates', [App\Http\Controllers\UserPortalController::class, 'certificates'])->name('user.certificates.index');
    Route::post('/user/certificates', [App\Http\Controllers\UserPortalController::class, 'storeCertificate'])->name('user.certificates.store');
    Route::get('/user/support', [App\Http\Controllers\UserPortalController::class, 'support'])->name('user.support.create');
    Route::post('/user/support', [App\Http\Controllers\UserPortalController::class, 'storeSupport'])->name('user.support.store');

    // Admin Routes
    Route::middleware(['role.admin'])->group(function () {
        // Citizens CRUD
        Route::resource('citizens', CitizenController::class);

        // Pension Schemes CRUD
        Route::resource('pension-schemes', PensionSchemeController::class);

        // Admin Applications
        Route::get('applications', [App\Http\Controllers\ApplicationController::class, 'index'])->name('applications.index');
        Route::get('applications/{application}', [App\Http\Controllers\ApplicationController::class, 'show'])->name('applications.show');
        Route::put('applications/{application}', [App\Http\Controllers\ApplicationController::class, 'update'])->name('applications.update');

        // Admin Tickets (Support)
        Route::get('tickets', [App\Http\Controllers\AdminTicketController::class, 'index'])->name('admin.tickets.index');
        Route::put('tickets/{ticket}', [App\Http\Controllers\AdminTicketController::class, 'update'])->name('admin.tickets.update');

        // Citizen Pensions CRUD
        Route::resource('citizen-pensions', CitizenPensionController::class);

        // Search
        Route::get('/search', [SearchController::class, 'index'])->name('search.index');

        // Duplicate Detection
        Route::prefix('duplicate-detection')->group(function () {
            Route::get('/', [DuplicateDetectionController::class, 'index'])->name('duplicate-detection.index');
            Route::post('/scan', [DuplicateDetectionController::class, 'scan'])->name('duplicate-detection.scan');
            Route::post('/{duplicate}/review', [DuplicateDetectionController::class, 'review'])->name('duplicate-detection.review');
        });
    });
});
