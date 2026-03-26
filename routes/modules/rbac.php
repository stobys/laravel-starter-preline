<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RBAC\RoleController;

// use App\Livewire\RbacPermissionsManager;
// use App\Livewire\RbacRolesManager;
// use App\Livewire\RbacUsersManager;


// -- LiveWire
// Route::middleware(['auth', 'verified'])->group(function () {
//     // RBAC Management
//     Route::prefix('rbac')->name('rbac.')->group(function () {
//         Route::get('/permissions', RbacPermissionsManager::class)->name('permissions');
//         Route::get('/roles', RbacRolesManager::class)->name('roles');
//         Route::get('/users', RbacUsersManager::class)->name('users');
//     });
// });


// -- ROUTING GROUP
Route::middleware(['auth'])->group(function () {
    Route::prefix('roles')->name('roles.')->group(function() {
        Route::get('/',                 [RoleController::class, 'index'])   -> name('index');
        Route::post('/',                [RoleController::class, 'filter'])   -> name('filter');

        Route::get('/{role}',           [RoleController::class, 'show'])    -> name('show')->withTrashed();
        Route::get('/create',           [RoleController::class, 'create'])  -> name('create');
        Route::post('/store',           [RoleController::class, 'store'])   -> name('store');
        Route::get('/{role}/edit',      [RoleController::class, 'edit'])    -> name('edit')->withTrashed();
        Route::patch('/{role}',         [RoleController::class, 'update'])  -> name('update')->withTrashed();
        Route::get('/{role}/delete',    [RoleController::class, 'delete'])  -> name('delete');
        Route::get('/{role}/restore',   [RoleController::class, 'restore']) -> name('restore')->withTrashed();

        Route::get('/permissions-list', [RoleController::class, 'permissions'])   -> name('permissions-list');
    });
});
