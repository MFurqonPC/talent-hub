<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\OpportunityController;
use App\Http\Controllers\Admin\RewardController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Mahasiswa\CertificateController;
use App\Http\Controllers\Mahasiswa\PortfolioController;
use App\Http\Controllers\Mahasiswa\RecommendationController;
use App\Http\Controllers\Mahasiswa\RewardCatalogController;
use App\Http\Controllers\Mahasiswa\SkillController;
use App\Http\Controllers\Mahasiswa\TalentProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard setelah login
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// ================== ROUTE LOGIN ==================
Route::middleware('auth')->group(function () {

    // ================== PROFILE BREEZE ==================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // ================== ROUTE MAHASISWA ==================
    Route::prefix('mahasiswa')
        ->name('mahasiswa.')
        ->group(function () {

            Route::get('/dashboard', function () {
                return auth()->user()->role === 'admin'
                    ? redirect()->route('admin.dashboard')
                    : redirect()->route('mahasiswa.profile.edit');
            })->middleware(['auth', 'verified'])->name('dashboard');
            // Talent Profile
            Route::get('/profile', [TalentProfileController::class, 'edit'])
                ->name('profile.edit');

            Route::put('/profile', [TalentProfileController::class, 'update'])
                ->name('profile.update');

            // Skills
            Route::get('/skills', [SkillController::class, 'index'])
                ->name('skills.index');

            Route::post('/skills', [SkillController::class, 'store'])
                ->name('skills.store');

            Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])
                ->name('skills.destroy');

            // Certificates
            Route::get('/certificates', [CertificateController::class, 'index'])
                ->name('certificates.index');

            Route::post('/certificates', [CertificateController::class, 'store'])
                ->name('certificates.store');

            Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy'])
                ->name('certificates.destroy');

            // Portfolios
            Route::get('/portfolios', [PortfolioController::class, 'index'])
                ->name('portfolios.index');

            Route::post('/portfolios', [PortfolioController::class, 'store'])
                ->name('portfolios.store');

            Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])
                ->name('portfolios.destroy');

            // Leaderboard
            Route::get('/leaderboard', [LeaderboardController::class, 'index'])
                ->name('leaderboard');

            // Reward Catalog
            Route::get('/rewards', [RewardCatalogController::class, 'index'])
                ->name('rewards.index');

            Route::post('/rewards/{reward}/claim', [RewardCatalogController::class, 'claim'])
                ->name('rewards.claim');

            // AI Recommendation
            Route::get('/recommendations', [RecommendationController::class, 'index'])
                ->name('recommendations.index');

        });
});

// ================== ROUTE ADMIN ==================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Leaderboard
        Route::get('/leaderboard', [LeaderboardController::class, 'index'])
            ->name('leaderboard');

        // ================== VERIFICATION ==================
        Route::get('/verifications', [VerificationController::class, 'index'])
            ->name('verifications.index');

        // Skill
        Route::post('/verifications/skills/{skill}/approve', [VerificationController::class, 'approveSkill'])
            ->name('verifications.skills.approve');

        Route::post('/verifications/skills/{skill}/reject', [VerificationController::class, 'rejectSkill'])
            ->name('verifications.skills.reject');

        // Certificate
        Route::post('/verifications/certificates/{certificate}/approve', [VerificationController::class, 'approveCertificate'])
            ->name('verifications.certificates.approve');

        Route::post('/verifications/certificates/{certificate}/reject', [VerificationController::class, 'rejectCertificate'])
            ->name('verifications.certificates.reject');

        // Portfolio
        Route::post('/verifications/portfolios/{portfolio}/approve', [VerificationController::class, 'approvePortfolio'])
            ->name('verifications.portfolios.approve');

        Route::post('/verifications/portfolios/{portfolio}/reject', [VerificationController::class, 'rejectPortfolio'])
            ->name('verifications.portfolios.reject');

        // ================== REWARD MANAGEMENT ==================
        Route::get('/rewards', [RewardController::class, 'index'])
            ->name('rewards.index');

        Route::post('/rewards', [RewardController::class, 'store'])
            ->name('rewards.store');

        Route::put('/rewards/{reward}', [RewardController::class, 'update'])
            ->name('rewards.update');

        Route::delete('/rewards/{reward}', [RewardController::class, 'destroy'])
            ->name('rewards.destroy');

        // ================== OPPORTUNITY MANAGEMENT ==================
        Route::get('/opportunities', [OpportunityController::class, 'index'])
            ->name('opportunities.index');

        Route::post('/opportunities', [OpportunityController::class, 'store'])
            ->name('opportunities.store');

        Route::delete('/opportunities/{opportunity}', [OpportunityController::class, 'destroy'])
            ->name('opportunities.destroy');
    });

require __DIR__ . '/auth.php';
