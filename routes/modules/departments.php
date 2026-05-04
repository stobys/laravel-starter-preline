<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
// use App\Http\Controllers\DepartmentThinController;

Route::middleware('auth')->group(function () {
    Route::prefix('departments')->name('departments.')->group(function () {
            Route::get('/',         [DepartmentController::class, 'index']) -> name('index');
			Route::post('/',        [DepartmentController::class, 'filter'])   -> name('filter');

			Route::get('/sync-teta',   		[DepartmentController::class, 'syncTeta'])	-> name('sync-teta');

            Route::get('create',  [DepartmentController::class, 'create']) -> name('create');
            Route::post('create',  [DepartmentController::class, 'store']) -> name('store');

            Route::post('import',  [DepartmentController::class, 'import']) -> name('import');
            // Route::get('download', [DepartmentController::class, 'download']) -> name('download');

            Route::get('{department}',  [DepartmentController::class, 'show']) -> name('show')->withTrashed();

            Route::get('{department}/edit',  [DepartmentController::class, 'edit']) -> name('edit')->withTrashed();
            Route::patch('{department}',  [DepartmentController::class, 'update']) -> name('update')->withTrashed();

            Route::get('{department}/delete',    [DepartmentController::class, 'delete']) -> name('delete');
            Route::get('{department}/restore',   [DepartmentController::class, 'restore'])->name('restore')->withTrashed();

    });
});
