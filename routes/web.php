<?php

use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MatchController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Home page - Tournament overview for all users
Route::get('/', [TournamentController::class, 'index'])->name('home');

// Public routes - Tournament information accessible to all
Route::get('/schedule', [MatchController::class, 'index'])->name('matches.index');
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
Route::get('/matches/{tournamentMatch}', [MatchController::class, 'show'])->name('matches.show');

// Admin routes - Team and match management (requires authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    
    // Team management
    Route::get('/admin/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/admin/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/admin/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::patch('/admin/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/admin/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    
    // Match management
    Route::get('/admin/matches/create', [MatchController::class, 'create'])->name('matches.create');
    Route::post('/admin/matches', [MatchController::class, 'store'])->name('matches.store');
    Route::get('/admin/matches/{tournamentMatch}/edit', [MatchController::class, 'edit'])->name('matches.edit');
    Route::patch('/admin/matches/{tournamentMatch}', [MatchController::class, 'update'])->name('matches.update');
    Route::delete('/admin/matches/{tournamentMatch}', [MatchController::class, 'destroy'])->name('matches.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
