<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FaunaController;
use App\Http\Controllers\FaunaLocationController;
use App\Http\Controllers\FaunaDetailController;
use App\Http\Controllers\HerbalController;
use App\Http\Controllers\HerbalDetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\SearchController;
use App\Models\Fauna;
use App\Models\Taxonomy;
use App\Models\Herbal;
use App\Models\Symptom;
use App\Models\FaunaLocation;
use App\Models\Contribution;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    $faunas = Fauna::with('taxonomy', 'locations')->latest()->take(4)->get();
    $herbals = Herbal::latest()->take(4)->get();
    return view('homepage.page', compact('faunas', 'herbals'));
})->name('homepage');

// Katalog & Detail Fauna
Route::get('/spesies', [FaunaController::class, 'index'])->name('spesies');

Route::get('/detail-spesies/{id?}', function ($id = null) {
    $fauna = $id
        ? Fauna::with('taxonomy', 'locations')->find($id)
        : Fauna::with('taxonomy', 'locations')->first();

    if (!$fauna) {
        return redirect()->route('spesies');
    }

    $relatedFaunas = Fauna::where('id', '!=', $fauna->id)->take(3)->get();
    return view('detail-spesies.page', compact('fauna', 'relatedFaunas'));
})->name('detail-spesies');

// Katalog & Detail Herbal (TOGA)
Route::get('/herbal', [HerbalController::class, 'index'])->name('herbal');

Route::get('/detail-herbal/{id?}', function ($id = null) {
    $herbal = $id
        ? Herbal::with(['symptoms', 'activeCompounds', 'interactions', 'gallery'])->find($id)
        : Herbal::with(['symptoms', 'activeCompounds', 'interactions', 'gallery'])->first();

    if (!$herbal) {
        return redirect()->route('herbal');
    }

    $relatedHerbals = Herbal::where('id', '!=', $herbal->id)->take(3)->get();
    return view('detail-herbal.page', compact('herbal', 'relatedHerbals'));
})->name('detail-herbal');


Route::get('/map', function () {
    $faunas = Fauna::with(['taxonomy', 'locations', 'ecologicalInfo', 'physicalCharacteristics'])->get();
    $herbals = Herbal::with(['symptoms', 'activeCompounds'])->get();
    $taxonomies = Taxonomy::all();
    return view('peta-interaktif.page', compact('faunas', 'herbals', 'taxonomies'));
})->name('map');

Route::get('/wizard/herbal',function () {
    return redirect()->route('herbal');
})->name('wizard.herbal');

Route::post('/wizard/herbal/search', [HerbalController::class, 'findBySymptom'])->name('wizard.herbal.search');

Route::get('/wizard/fauna', function () {
    return redirect()->route('spesies');
})->name('wizard.fauna');

Route::get('/api/gis/fauna-locations', [FaunaController::class, 'getMapLocations'])->name('api.gis.fauna');

Route::get('/riset', function () {
    return view('riset.page');
})->name('riset');

Route::get('/kontribusi', function () {
    $myContributions = Auth::check()
        ? Contribution::where('user_id', Auth::id())
            ->with('reviewer:id,name')
            ->latest()
            ->get()
        : collect();
    return view('kontribusi.page', compact('myContributions'));
})->name('kontribusi');

Route::get('/api/global-search', [SearchController::class, 'globalSearch'])->name('api.global-search');

Route::middleware('guest')->group(function () {
    // Admin Login Routes
    Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');

    // User Login
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

    // Crowdsourcing
    Route::post('/contribute', [ContributionController::class, 'submitContribution'])->name('contribute.submit');

    // Admin Grouping
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('homepage')->with('error', 'Anda tidak memiliki hak akses ke Panel Admin.');
            }

            $totalFauna = Fauna::count();
            $totalHerbal = Herbal::count();
            $totalGis = FaunaLocation::count();
            $pendingCount = Contribution::where('status', 'pending')->count();

            $contributions = Contribution::with('author')->latest()->get();
            $recentLogs = Contribution::with(['author', 'reviewer'])->latest()->take(6)->get();

            $iucnCounts = Fauna::select('iucn_status', DB::raw('count(*) as total'))
                ->groupBy('iucn_status')
                ->pluck('total', 'iucn_status')
                ->toArray();

            $taxonomies = Taxonomy::all();

            return view('admin.dashboard', compact(
                'totalFauna',
                'totalHerbal',
                'totalGis',
                'pendingCount',
                'contributions',
                'recentLogs',
                'iucnCounts',
                'taxonomies'
            ));
        })->name('dashboard');

        Route::resource('fauna', FaunaController::class)->except(['show']);
        Route::resource('fauna-locations', FaunaLocationController::class)->only(['index', 'store', 'destroy']);
        Route::get('/fauna-details', [FaunaDetailController::class, 'index'])->name('fauna-details.index');
        Route::post('/fauna-details/{id}', [FaunaDetailController::class, 'update'])->name('fauna-details.update');
        Route::resource('herbal', HerbalController::class)->except(['show']);
        Route::get('/herbal-details', [HerbalDetailController::class, 'index'])->name('herbal-details.index');
        Route::post('/herbal-details/{id}', [HerbalDetailController::class, 'update'])->name('herbal-details.update');
        Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::patch('/contributions/{id}/moderate', [ContributionController::class, 'moderateContribution'])->name('contributions.moderate');
        Route::post('/contributions/{id}/approve', [ContributionController::class, 'approveContribution'])->name('contributions.approve');
        Route::post('/contributions/{id}/reject', [ContributionController::class, 'rejectContribution'])->name('contributions.reject');
        Route::get('/crowdsourcing', [ContributionController::class, 'adminIndex'])->name('crowdsourcing.index');
        Route::delete('/fauna/{id}', [FaunaController::class, 'destroy'])->name('fauna.destroy');
        Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings');
        Route::post('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    });

});
