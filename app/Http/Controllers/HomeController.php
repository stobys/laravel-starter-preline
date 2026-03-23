<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    public function home()
    {
        if( Auth::user() ) {
            return redirect()->route('dashboard');
        }

        return view('welcome');
    }

    public function dashboard()
    {

        $departments = []; // Department::withCount('trainings', 'members')
            // ->withSum('trainings', 'planned_cost')
            // ->withAvg('trainings', 'planned_cost')
            // ->get();


    // $policy = Gate::getPolicyFor(get_class($model));
    // dd([
    //     'policy_class' => $policy ? get_class($policy) : 'No policy found',
    //     'user' => auth()->user(),
    //     'model' => $model->toArray(),
    //     'gate_check' => Gate::allows('update', $model),
    //     'policy_check' => $policy ? $policy->update(auth()->user(), $model) : 'No policy'
    // ]);

        return view('dashboard', compact('departments'));
    }

    public function phpinfo()
    {
        phpinfo();
        die();
    }

    public function error($status = 200)
    {
        abort($status, 'Testin! Testin!');
    }

    public function myApprovals()
    {
        $user = auth()->user();

        $pending = Approval::where('status', 'pending')
            ->whereHas('step', function($q) use ($user) {
                $q->whereIn('role_name', $user->roles->pluck('name'));
            })
            ->with('approvable')
            ->get();

        return view('approvals.index', compact('pending'));
    }
}
