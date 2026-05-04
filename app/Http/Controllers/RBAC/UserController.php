<?php

namespace App\Http\Controllers\RBAC;

use App\Collections\NotificationSettingCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\ACRole;
use App\Models\Department;
use App\Models\NotificationSetting;
use App\Models\User;
use App\Services\Filters\UserFiltersService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function json()
    {
		// $this->authorize('json', User::class);

		$users = User::with('department')->get();
		$users = UserResource::collection($users);

    	return response()->json($users);
    }

    public function index(UserFiltersService $filters)
    {
        $users = $filters->apply()->applySort()->paginate( config('app.paginator.items_per_page') );
		$departments = Department::select('id', 'name')->get();

        return view('mgmt.users.index', compact('users', 'departments'));
    }

    public function filter(Request $request, UserFiltersService $filters)
    {
        $filters->save($request->only('filters'));
        return redirect()->route('users.index');
    }

    public function create(User $user)
    {
        $roles = ACRole::select(['id', 'name'])->get();
		// $users = User::select(['id', 'full_name'])->get()->pluck('id', 'full_name')->all();
		$departments = Department::select(['id', 'name'])->get();

        return view('mgmt.users.create', compact('user', 'roles', 'departments'));
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

        return redirect()->route('users.index') -> with('success', 'Role użytkownika zostały zaktualizowane.');
    }

    public function edit(User $user)
    {
        $roles = ACRole::select(['id', 'name'])->get();
		// $users = User::select(['id', 'full_name'])->get()->pluck('id', 'full_name')->all();
		$departments = Department::select(['id', 'name', 'teta_mpk_code'])->get();

        return view('mgmt.users.edit', compact('user', 'roles', 'departments'));
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

    public function show(User $user)
    {
		$user->load('roles');

		$roles = ACRole::select(['id', 'name'])->get();
		$users = User::select(['id', 'full_name'])->get()->pluck('id', 'full_name')->all();

		return view('mgmt.users.show', compact('user', 'users', 'roles'));
    }

    public function settings()
    {
		$user = auth()->user(); // ->load('roles');

		$roles = ACRole::select(['id', 'name'])->get();
		$users = User::select(['id', 'full_name'])->get()->pluck('id', 'full_name')->all();

		if(request()->method() == 'POST')
		{
			NotificationSettingCollection::saveSettings();
		}

		return view('mgmt.users.settings', compact('user', 'users', 'roles'));
    }

	public function avatar(User $user): BinaryFileResponse
	{
		// Zakładając że user ma pole np. `avatar_path` w bazie
		// $file = $user?->avatar_path;

		// if (!$file || !Storage::exists($file)) {
		// 	// Zwróć domyślny avatar
		// 	$path = 'img/avatars/default-avatar.png';
		// }

		$disk = Storage::disk('avatars');
		$username = $user->username ?? 'default-avatar';
		$path = $disk->exists($username) ? $username : 'default-avatar';

		$lastModified = $disk->lastModified( $path );
		// $mimeType = $disk->mimeType($path);
		// $file     = $disk->get($path);

		return response()->file($disk->path($path), [
			'Cache-Control' => 'public, max-age=604800', // 7 dni
			'Last-Modified' => gmdate('D, d M Y H:i:s', $lastModified) . ' GMT',
			'ETag'          => md5($user->id . $lastModified),
		]);
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

	public function syncTeta()
	{
		// -- test bazy
		try {
			DB::connection('oracle')->getPdo();

			// -- Wywołaj komendę synchronicznie
			Artisan::call('sync:teta', ['model' => 'employee']);

		} catch (\Exception $e) {
			dd($e->getMessage());

			abort(503, 'Baza TETA jest niedostępna');
		}

        return redirect()->back();
	}

	public function syncLdap($username = null)
	{
		try {
			// -- Wywołaj komendę synchronicznie
			Artisan::call('sync:ldap');
		}
		 catch (\Exception $e) {
			abort(500);
		}

		return redirect()->back();
	}
}
