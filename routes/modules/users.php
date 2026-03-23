<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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
    Route::prefix('users')->name('users.')->group(function() {
        Route::get('/',                 [UserController::class, 'index'])   -> name('index');
        Route::post('/',                [UserController::class, 'filter'])   -> name('filter');

        // Route::get('/{user}',           [UserController::class, 'show'])    -> name('show');
        Route::get('/create',           [UserController::class, 'create'])  -> name('create');
        Route::post('/store',           [UserController::class, 'store'])   -> name('store');
        Route::get('/{user}/edit',      [UserController::class, 'edit'])    -> name('edit')->withTrashed();
        Route::patch('/{user}',         [UserController::class, 'update'])  -> name('update')->withTrashed();
        Route::get('/{user}/delete',    [UserController::class, 'delete'])  -> name('delete');
        Route::get('/{user}/restore',   [UserController::class, 'restore']) -> name('restore')->withTrashed();

        // Route::get('/password/{user?}', ['as' => 'users-change-password',       'uses' => 'UsersController@changePassword']);
        // Route::patch('/password/{user?}',['as' => 'users-do-change-password',    'uses' => 'UsersController@changePassword']);


        // Route::group(['prefix' => 'roles'], function() {
        //     Route::get('/',                 ['as' => 'users-roles-index',     'uses' => 'UsersRolesController@index']);
        //     Route::get('/trash',            ['as' => 'users-roles-trash',     'uses' => 'UsersRolesController@trash']);
        //     Route::get('/create',           ['as' => 'users-roles-create',    'uses' => 'UsersRolesController@create']);
        //     Route::post('/',                ['as' => 'users-roles-store',     'uses' => 'UsersRolesController@store']);
        //     Route::get('/{role}/edit',      ['as' => 'users-roles-edit',      'uses' => 'UsersRolesController@edit']);
        //     Route::get('/{role}',           ['as' => 'users-roles-show',      'uses' => 'UsersRolesController@show']);
        //     Route::patch('/{role}',         ['as' => 'users-roles-update',    'uses' => 'UsersRolesController@update']);
        //     Route::get('/{role}/delete',    ['as' => 'users-roles-delete',    'uses' => 'UsersRolesController@delete']);
        //     Route::get('/{role}/restore',   ['as' => 'users-roles-restore',   'uses' => 'UsersRolesController@restore']);
        // });
    });
});
