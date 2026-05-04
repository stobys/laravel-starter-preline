<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SecurityAuditController;

Route::prefix('security')->name('security.')->middleware(['auth'])->group(function () {
	Route::get('/',     [SecurityAuditController::class, 'index'])    ->name('index');
	Route::post('/run', [SecurityAuditController::class, 'runAudit']) ->name('run');
});
