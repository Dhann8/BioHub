<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaunaController;
use App\Http\Controllers\HerbalController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\PaperController;

// Fauna API Routes (/api/fauna)
Route::prefix('fauna')->group(function () {
    Route::get('/', [FaunaController::class, 'index'])->name('fauna.index');
    Route::get('/map-locations', [FaunaController::class, 'getMapLocations'])->name('fauna.map');
    Route::get('/{id}', [FaunaController::class, 'show'])->name('fauna.show');
    Route::post('/', [FaunaController::class, 'store'])->name('fauna.store');
    Route::put('/{id}', [FaunaController::class, 'update'])->name('fauna.update');
    Route::delete('/{id}', [FaunaController::class, 'destroy'])->name('fauna.destroy');
});

// Herbal API Routes (/api/herbal)
Route::prefix('herbal')->group(function () {
    Route::get('/', [HerbalController::class, 'index'])->name('herbal.index');
    Route::get('/by-symptom', [HerbalController::class, 'findBySymptom'])->name('herbal.by-symptom');
    Route::get('/{id}', [HerbalController::class, 'show'])->name('herbal.show');
    Route::post('/', [HerbalController::class, 'store'])->name('herbal.store');
    Route::put('/{id}', [HerbalController::class, 'update'])->name('herbal.update');
    Route::delete('/{id}', [HerbalController::class, 'destroy'])->name('herbal.destroy');
});

// Contribution API Routes (/api/contribution)
Route::prefix('contribution')->group(function () {
    Route::get('/', [ContributionController::class, 'index'])->name('contribution.index');
    Route::get('/{id}', [ContributionController::class, 'show'])->name('contribution.show');
    Route::post('/submit', [ContributionController::class, 'submitContribution'])->name('contribution.submit');
    Route::put('/{id}/moderate', [ContributionController::class, 'moderateContribution'])->name('contribution.moderate');
});

// Contribution API Routes (/api/papers)
Route::prefix('papers')->group(function () {
    Route::get('/', [PaperController::class, 'index'])->name('papers.index');
    Route::get('/most-cited', [PaperController::class, 'mostCited'])->name('papers.most-cited');
    Route::get('/{id}/download', [PaperController::class, 'download'])->name('papers.download');
});


