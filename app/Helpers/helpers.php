<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
