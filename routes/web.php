<?php

use App\Livewire\Leaderboards\Leaderboard251;
use App\Livewire\Leaderboards\Leaderboard252;
use App\Livewire\Leaderboards\Leaderboard253;
use App\Livewire\Leaderboards\Leaderboard254;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Scores\ScoresOpenWod251;
use App\Livewire\Scores\ScoresOpenWod252;
use App\Livewire\Scores\ScoresOpenWod253;
use App\Livewire\Scores\ScoresOpenWod254;
use App\Livewire\Teams\Overview as TeamOverview;
use App\Livewire\Teams\Detail as TeamDetail;
use Illuminate\Support\Facades\Route;

Route::redirect('/', auth()->check() ? 'dashboard' : 'login')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::redirect('scores', 'scores/bonus-wod-25.4')->name('scores.overview');
    Route::get('scores/open-wod-25.1', ScoresOpenWod251::class)->name('scores.open-wod-25.1');
    Route::get('scores/open-wod-25.2', ScoresOpenWod252::class)->name('scores.open-wod-25.2');
    Route::get('scores/open-wod-25.3', ScoresOpenWod253::class)->name('scores.open-wod-25.3');
    Route::get('scores/bonus-wod-25.4', ScoresOpenWod254::class)->name('scores.bonus-wod-25.4');

    Route::get('leaderboards/25.1', Leaderboard251::class)->name('leaderboards.25.1');
    Route::get('leaderboards/25.2', Leaderboard252::class)->name('leaderboards.25.2');
    Route::get('leaderboards/25.3', Leaderboard253::class)->name('leaderboards.25.3');
    Route::get('leaderboards/25.4', Leaderboard254::class)->name('leaderboards.25.4');

    Route::get('teams', TeamOverview::class)->name('teams.overview');
    Route::get('teams/{team:slug}', TeamDetail::class)->name('teams.detail');
});

require __DIR__.'/auth.php';
