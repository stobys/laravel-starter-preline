<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ServiceController extends Controller
{
    // -- Display service tasks panel
    public function index(): View
    {
		abort_unless(auth()->user()->isAlmighty(), 418);

        return view('service.index');
    }

    public function almightyAssign()
    {
        if( auth()->check() ) {
            Artisan::call('almighty:assign', ['username' => auth()->user()->username]);
        }

        return Redirect::to('/');
    }

    public function almightyRemove()
    {
        if( auth()->check() ) {
            Artisan::call('almighty:remove', ['username' => auth()->user()->username]);
        }

        return Redirect::to('/');
    }


}
