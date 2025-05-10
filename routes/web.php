<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');



    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    require __DIR__.'/auth.php';
