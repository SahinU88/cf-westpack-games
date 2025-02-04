<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/confirmed', 'confirmed')
    ->middleware(['auth'])
    ->name('confirmed');

Route::get('dashboard', function(){
        return to_route('confirmed');
    })
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

require __DIR__.'/auth.php';
