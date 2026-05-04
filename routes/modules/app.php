<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // -- Using Livewire component for profile editing
    // Route::get('/profile', ProfileEditor::class)->name('profile.edit');
    // Route::get('/settings', SettingsEditor::class)->name('settings.edit');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::post('/tasks/{task}/timer/start', [WorkLogController::class, 'start'])->name('tasks.timer.start');
    // Route::post('/tasks/{task}/timer/stop', [WorkLogController::class, 'stop'])->name('tasks.timer.stop');

    Route::get('/lang-switch/{lang}', [ProfileController::class, 'langSwitch'])->name('lang.switch');


    Route::get('/service-tasks', [ServiceController::class, 'index'])->name('service.index');

    // Route::get('/almighty/assign', [ServiceController::class, 'almightyAssign']);
    // Route::get('/almighty/remove', [ServiceController::class, 'almightyRemove']);

});
