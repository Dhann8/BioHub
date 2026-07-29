<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaunaController;
use App\Http\Controllers\HerbalController;
use App\Http\Controllers\ContributionController;
use App\Models\Fauna;
use App\Models\Taxonomy;
use App\Models\Herbal;
use App\Models\Symptom;


Route::get('/', function () {
    $faunas = Fauna::with('taxonomy', 'locations')->latest()->take(4)->get();
    $herbals = Herbal::latest()->take(4)->get();
    return view('homepage.page', compact('faunas', 'herbals'));
})->name('homepage');

// Katalog & Detail Fauna
Route::get('/satwa', function () {
    $faunas = Fauna::with('taxonomy', 'locations')->latest()->get();
    $taxonomies = Taxonomy::withCount('faunas')->get();
    return view('satwa.page', compact('faunas', 'taxonomies'));
})->name('satwa');

Route::get('/detail-satwa/{id?}', function ($id = null) {
    $fauna = $id 
        ? Fauna::with('taxonomy', 'locations')->find($id) 
        : Fauna::with('taxonomy', 'locations')->first();

    if (!$fauna) {
        return redirect()->route('satwa');
    }

    $relatedFaunas = Fauna::where('id', '!=', $fauna->id)->take(3)->get();
    return view('detail-satwa.page', compact('fauna', 'relatedFaunas'));
})->name('detail-satwa');

// Katalog & Detail Herbal (TOGA)
Route::get('/herbal', function () {
    $herbals = Herbal::latest()->get();
    return view('herbal.page', compact('herbals'));
})->name('herbal');

Route::get('/detail-herbal/{id?}', function ($id = null) {
    // FIX: Menggunakan relasi 'symptoms' (Bukan 'taxonomy'/'locations')
    $herbal = $id 
        ? Herbal::with('symptoms')->find($id) 
        : Herbal::with('symptoms')->first();

    if (!$herbal) {
        return redirect()->route('herbal');
    }

    $relatedHerbals = Herbal::where('id', '!=', $herbal->id)->take(3)->get();
    return view('detail-herbal.page', compact('herbal', 'relatedHerbals'));
})->name('detail-herbal');


Route::get('/map', function () {
    return view('peta-interaktif.page');
})->name('map');



// Herbal Consultation Wizard (Symptom-to-Remedy)
Route::get('/wizard/herbal', function () {
    $symptoms = Symptom::all();
    return view('wizard.herbal', compact('symptoms'));
})->name('wizard.herbal');

Route::post('/wizard/herbal/search', [HerbalController::class, 'findBySymptom'])->name('wizard.herbal.search');

// Fauna Identification Wizard
Route::get('/wizard/fauna', function () {
    $taxonomies = Taxonomy::all();
    return view('wizard.fauna', compact('taxonomies'));
})->name('wizard.fauna');

// Web GIS Map Data (Endpoints JSON untuk Leaflet.js)
Route::get('/api/gis/fauna-locations', [FaunaController::class, 'getMapLocations'])->name('api.gis.fauna');


Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Forgot & Reset Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});


Route::middleware('auth')->group(function () {
    // Logout
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    // Crowdsourcing (Masyarakat Mengirimkan Usulan Data Baru)
    Route::post('/contribute', [ContributionController::class, 'submitContribution'])->name('contribute.submit');

    // Grouping Dashboard Admin / Pakar (RBAC)
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard Overview
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // CRUD Management Routes
        Route::resource('fauna', FaunaController::class)->except(['show']);
        Route::resource('herbal', HerbalController::class)->except(['show']);

        // Moderation Crowdsourcing Queue
        Route::patch('/contributions/{id}/moderate', [ContributionController::class, 'moderateContribution'])->name('contributions.moderate');
    });
});