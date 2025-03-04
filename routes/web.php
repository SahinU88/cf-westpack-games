<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Scores\ScoresOpenWod251;
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

    Route::get('scores/open-wod-25.1', ScoresOpenWod251::class)->name('scores.open-wod-25.1');
});

require __DIR__.'/auth.php';
