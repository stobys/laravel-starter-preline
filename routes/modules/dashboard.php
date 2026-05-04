<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/stats/{year?}',  [DashboardController::class, 'stats']) -> name('stats');
            Route::get('/{year?}',  [DashboardController::class, 'index']) -> name('dashboard');
			Route::post('/',        [DashboardController::class, 'filter'])   -> name('filter');
    });
});
