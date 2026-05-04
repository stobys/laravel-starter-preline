<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('example', function () {
    return view('example');
});

Route::get('test', TestController::class);

// -- load controllers routes
loadModuleRoutesFiles(base_path('routes/modules'));

Route::any('/{page?}', [HomeController::class, 'notFound']) -> where('page','.*') -> name('catchAll');
