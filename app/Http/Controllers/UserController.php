<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\ACRole;
use App\Models\User;
use App\Services\PermissionService;
use App\Services\UserFiltersService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index(UserFiltersService $filters)
    {
        $users = $filters->apply()->paginate( config('app.paginator.items_per_page') );

        return view('mgmt.users.index', compact('users'));
    }

    public function filter(Request $request, UserFiltersService $filters)
    {
        $filters->save($request->only('filters'));
        return redirect()->route('users.index');
    }

    public function create(User $user)
    {
        $roles = ACRole::select(['id', 'name'])->get();

        return view('mgmt.users.create', compact('user', 'roles'));
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->safe()->except(['roles']);
        $user = User::create($data);

        if ($user->exists) {
            $roles = $request->safe()->only(['roles']);
            $roles = Arr::get($roles, 'roles', []);
            $user->roles()->sync($roles);
        }

        // if ($user->hasErrors()) {
        //     return redirect()->back()->withInput()->withErrors($user->getErrors());
        // }

        // $model->saveImage();
        return redirect()->route('users.index') -> with('success', 'Role użytkownika zostały zaktualizowane.');
    }

    public function edit(User $user)
    {
        $roles = ACRole::select(['id', 'name'])->get();

        return view('mgmt.users.edit', compact('user', 'roles'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->safe()->except(['roles']);

        // jeśli hasło jest puste, usuń je z tablicy danych
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
            // $data['password_changed_at'] = now();
        }

        if ($user->update($data)) {
            $roles = $request->safe()->only(['roles']);
            $roles = Arr::get($roles, 'roles', []);
            $user->roles()->sync($roles);

            // $model->saveImage();
            return redirect()->route('users.index') -> with('success', 'Role użytkownika zostały zaktualizowane.');
        }

        return redirect()->back()->withInput()->withErrors($user->getErrors());
    }

    public function delete(User $user)
    {
        if ($user->delete()) {
            // flash('element-delete-confirmation', 'element usuniety');
        }

        return redirect()->route('users.index');
    }

    public function restore(User $user)
    {
        if ($user->restore()) {
            // flash('element-delete-confirmation', 'element usuniety');
        }

        return redirect()->route('users.index');
    }

    public function assignRoles(User $user)
    {
        $roles = Role::orderBy('context')->orderBy('name')->get();
        $contexts = Context::all();

        // Pobierz aktualne role użytkownika pogrupowane po kontekście
        $userRoles = $user->roles()
                         ->withPivot(['context_id', 'expires_at'])
                         ->get()
                         ->groupBy('pivot.context_id');

        return view('cms.users.assign-roles', compact('user', 'roles', 'contexts', 'userRoles'));
    }

    public function updateRoles(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'array',
            'roles.*' => 'array',
            'roles.*.*' => 'exists:roles,id',
            'expires_at' => 'array',
            'expires_at.*' => 'nullable|date|after:now'
        ]);

        DB::transaction(function () use ($user, $validated, $request) {
            // Usuń wszystkie aktualne role
            $user->roles()->detach();

            // Przypisz nowe role z kontekstem
            foreach ($validated['roles'] ?? [] as $contextId => $roleIds) {
                foreach ($roleIds as $roleId) {
                    $expiresAt = $validated['expires_at'][$contextId] ?? null;

                    $user->roles()->attach($roleId, [
                        'context_id' => $contextId === 'null' ? null : $contextId,
                        'granted_by' => auth()->id(),
                        'expires_at' => $expiresAt,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        });

        // Wyczyść cache uprawnień użytkownika
        $this->clearUserPermissionCache($user->id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role użytkownika zostały zaktualizowane.'
            ]);
        }

        return redirect()->route('cms.users.show', $user)
                        ->with('success', 'Role użytkownika zostały zaktualizowane.');
    }

    public function revokeRole(Request $request, User $user, Role $role)
    {
        $validated = $request->validate([
            'context_id' => 'nullable|exists:contexts,id'
        ]);

        $query = $user->roles()->where('role_id', $role->id);

        if ($validated['context_id']) {
            $query->wherePivot('context_id', $validated['context_id']);
        } else {
            $query->wherePivot('context_id', null);
        }

        $query->detach();

        $this->clearUserPermissionCache($user->id);

        return response()->json([
            'success' => true,
            'message' => 'Rola została odebrana użytkownikowi.'
        ]);
    }

    public function getUserPermissions(User $user, Request $request)
    {
        $contextId = $request->get('context_id');
        $permissions = $user->getPermissions($contextId);

        return response()->json([
            'user' => $user,
            'context_id' => $contextId,
            'permissions' => $permissions->groupBy('resource')
        ]);
    }

    protected function clearUserPermissionCache($userId)
    {
        cache()->forget("user_permissions_{$userId}_global");
        cache()->forget("user_permissions_{$userId}_organization");
        cache()->forget("user_permissions_{$userId}_project");
    }
}
