<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Number;
use App\Models\User;

if (!function_exists('user')) {
    function user()
    {
        return Auth::user();
    }
}

if (!function_exists('batchUser')) {
    function batchUser()
    {
        return User::whereUsername('batch')->firstOrFail();
    }
}

if (!function_exists('format_as_number')) {
    function format_as_number($value, $decimals = 0)
    {
		if( !is_numeric($value) ) return 0;

		return Number::format($value, $decimals, locale: 'pl_PL');
    }
}

if (!function_exists('loadModuleRoutesFiles')) {
	function loadModuleRoutesFiles(string $path): void
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
			loadModuleRoutesFiles($directory);
		}
	}
}
