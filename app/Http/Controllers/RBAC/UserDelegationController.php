<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserDelegationStoreRequest;
use App\Http\Requests\User\UserDelegationUpdateRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Models\UserDelegation;
use App\Services\Filters\UserDelegationFiltersService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserDelegationController extends Controller
{
    public function __construct()
    {
    }

    public function index(UserDelegationFiltersService $filters)
    {
		// -- others give permission to user
        $incoming = $filters->apply()->incoming()->applySort()->paginate( config('app.paginator.items_per_page') );

		// -- user give permission to others
        $outgoing = $filters->apply()->outgoing()->applySort()->paginate( config('app.paginator.items_per_page') );

        return view('mgmt.delegations.index', compact('incoming', 'outgoing'));
    }

    public function filter(Request $request, UserDelegationFiltersService $filters)
    {
        $filters->save($request->only('filters'));
        return redirect()->route('users.index');
    }

    public function create(User $user)
    {
		$users = User::withoutBuiltIn()->select(['id', 'full_name'])->get();

        return view('mgmt.delegations.create', compact('users'));
    }

    public function store(UserDelegationStoreRequest $request)
    {
        UserDelegation::create($request->validated() + ['principal_id' => auth()->id()]);

        return redirect()->route('users.delegations.index') -> with('success', 'Zastępstwo zostało utworzone.');
    }

    public function edit(UserDelegation $delegation)
    {
		$users = User::withoutBuiltIn()->select(['id', 'full_name'])->get();

        return view('mgmt.delegations.edit', compact('users', 'delegation'));
    }

    public function update(UserDelegationUpdateRequest $request, UserDelegation $delegation)
    {
		$delegation->update($request->validated() + ['principal_id' => auth()->id()]);

        return redirect()->route('users.delegations.index') -> with('success', 'Zastępstwo zostało zaktualizowane.');
    }

    public function delete(UserDelegation $delegation)
    {
        if ($delegation->delete()) {
            // flash('element-delete-confirmation', 'element usuniety');
        }

        return redirect()->route('users.delegations.index');
    }

    // public function restore(UserDelegation $delegation)
    // {
    //     if ($delegation->restore()) {
    //         // flash('element-delete-confirmation', 'element usuniety');
    //     }

    //     return redirect()->route('users.delegations.index');
    // }


}
