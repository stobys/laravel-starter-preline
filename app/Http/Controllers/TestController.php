<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TestController extends Controller
{

	// -- GET /test?status=approved&department=it&year=2026
    public function __invoke(Request $request)
    {
		abort_unless(auth()->user()->isAlmighty(), 418);

		// $request->param_name, $params['param_name']
		$params = $request->only(['training_id']);

		$training_id = $request->training_id;

		dd($training_id);
    }

}

