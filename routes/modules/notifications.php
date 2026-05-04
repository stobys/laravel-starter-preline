<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::middleware('auth')->group(function () {

    // Route::prefix('notifications')->name('notifications.')->group(function () {
    //         Route::get('/',    [NotificationController::class, 'index']) -> name('index');

    //         Route::get('{notification}/details',  [NotificationController::class, 'details']) -> name('details');

    //         Route::get('{notification}/delete',  [NotificationController::class, 'delete']) -> name('delete');
    // });

});
