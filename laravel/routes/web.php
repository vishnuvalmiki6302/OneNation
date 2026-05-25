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

    // Citizens CRUD
    Route::resource('citizens', CitizenController::class);

    // Pension Schemes CRUD
    Route::resource('pension-schemes', PensionSchemeController::class);

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
