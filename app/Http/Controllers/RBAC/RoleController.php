<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Models\ACPermission;
use App\Models\ACResource;
use App\Models\ACRole;
use App\Services\RoleFiltersService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
// use App\Models\ACRole;
// use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{

    public function __construct()
    {

        // ensure admin has recently logged in, so it's not an unattended admin console being used
        // $this->middleware('password.confirm')->except(['index']);

        // // NOTE: These Gate:: definitions should be in an AuthServiceProvider or in a Model Policy, instead of in this Constructor.
        // // establish 2 permission rules for checking authorization later in this controller
        // Gate::define('can delete admins', function ($user) {
        //     return $user->hasAnyRole('Super-Admin', 'Admin');
        // });
        // Gate::define('can delete super-admins', function ($user) {
        //     return $user->hasRole('Super-Admin');
        // });
    }

    /**
     * Show the RBAC management dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(RoleFiltersService $filters)
    {
        $roles = $filters->apply()->withCount('permissions')->paginate(config('app.paginator.items_per_page'));

        return view('mgmt.roles.index', compact('roles'));
    }

    public function filter(Request $request, RoleFiltersService $filters)
    {
        $filters->save($request->only('filters'));
        return redirect()->route('roles.index');
    }

    public function show(ACRole $role)
    {
        $resources = ACResource::select(['id', 'name'])->with('permissions')->get();
        $role->load('permissions');

        return view('mgmt.roles.show', compact('resources', 'role'));
    }

    public function create(ACRole $role)
    {
        $resources = ACResource::select(['id', 'name'])->with('permissions')->get();

        return view('mgmt.roles.create', compact('resources', 'role'));
    }

    public function store(RoleStoreRequest $request)
    {
        $data = $request->safe()->only(['name']);
        $permissions = Arr::get($request->safe(['permissions']), 'permissions', []);

        $role = ACRole::create($data);
        $role -> permissions() -> sync($permissions);

        // if ($role->hasErrors()) {
        //     return redirect()->back()->withInput()->withErrors($role->getErrors());
        // }

        return redirect()->route('roles.index') -> with('success', 'Done!');
    }

    public function edit(ACRole $role)
    {
        $resources = ACResource::select(['id', 'name'])->with('permissions')->get();

        return view('mgmt.roles.edit', compact('role', 'resources'));
    }

    public function update(RoleUpdateRequest $request, ACRole $role)
    {
        $data = $request->safe()->only(['name']);

        if ($role->update($data)) {
            $permissions = Arr::get($request->safe(['permissions']), 'permissions', []);
            $role -> permissions() -> sync($permissions);
            // $model->saveImage();
            return redirect()->route('roles.index') -> with('success', 'DONE!');
        }

        return redirect()->back()->withInput()->withErrors($role->getErrors());
    }

    public function delete(ACRole $role)
    {
        if ($role->delete()) {
            // flash('element-delete-confirmation', 'DELETED!');
        }

        return redirect()->route('roles.index');
    }

    public function restore(ACRole $role)
    {
        if ($role->restore()) {
            // flash('element-delete-confirmation', 'RESTORED!');
        }

        return redirect()->route('roles.index');
    }

    public function permissions()
    {
        $resources = ACResource::select(['id', 'name'])->get();
        $permissions = ACPermission::with('resource')->paginate( config('app.paginator.items_per_page') );

 dd(auth()->user());

        return view('mgmt.roles.permissions', compact('resources', 'permissions'));
    }
}
