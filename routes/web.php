<?php

use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

// use App\Livewire\RbacPermissionsManager;
// use App\Livewire\RbacRolesManager;
// use App\Livewire\RbacUsersManager;

Route::get('/', function () {
    return view('welcome');
});

Route::get('example', function () {
    return view('example');
});

Route::get('dashboard', function () {
    return view('example');
})->name('dashboard');


// -- load controllers routes
loadModuleRoutes(base_path('routes/modules'));

Route::any('/{page?}', [HomeController::class, 'notFound']) -> where('page','.*') -> name('catchAll');

function loadModuleRoutes(string $path): void
{
    if (!File::isDirectory($path)) {
        return;
    }

    // Załaduj pliki PHP
    foreach (File::files($path) as $file) {
        if ($file->getExtension() === 'php') {
            require $file->getPathname();
        }
    }

    // Rekurencyjnie załaduj podkatalogi
    foreach (File::directories($path) as $directory) {
        loadModuleRoutes($directory);
    }
}
