<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use App\Services\PermissionService;

class RbacUsersManager extends Component
{
    use WithPagination;

    protected $sortableFields = ['last_name', 'username', 'email'];

    protected $usersService;

    public string $search = '';
    public int $pageSize = 10;
    public int $active = 1;     // 1 - active ; 2 - not active ; 4 - both

    public string $sortField = 'username';
    public string $sortDir = 'asc';

    public array $departments = [];
    public array $userRoles = [];
    public array $allRoles = [];

    public string $name = '';

    public bool $isUserModal = false;

    // public bool $showModal = false;
    // public bool $showDeleteModal = false;
    // public bool $editMode = false;
    // public string $search = '';
    // public bool $showTestEditModal = false;

    // Pola formularza z walidacją w czasie rzeczywistym
    // #[Validate]
    public $current_user_id = null;

    // #[Validate]
    public $department_id = null;

    // #[Validate]
    public $employee_number = null;

    // #[Validate]
    public string $first_name = '';

    // #[Validate]
    public string $last_name = '';

    // #[Validate]
    public string $username = '';

    // #[Validate]
    public string $email = '';

    // #[Validate]
    public string $password = '';

    // #[Validate]
    public string $password_confirmation = '';

    public ?User $userToDelete = null;

    protected $userService;

    public function boot(UserService $userService)
    {
        $this->authorize('rbac:manage-users');

        $this->userService = $userService;

            // Middleware z uprawnieniami
            // $this->middleware('permission:posts:read')->only(['index', 'show']);
            // $this->middleware('permission:posts:create')->only(['create', 'store']);
            // $this->middleware('permission:posts:update')->only(['edit', 'update']);
            // $this->middleware('permission:posts:delete')->only(['destroy']);
    }

    public function rules()
    {
        return $this->userService->getValidateRules($this->current_user_id);
    }

    public function messages()
    {
        return $this->userService->getValidateMessages();
    }

    // Walidacja w czasie rzeczywistym
    public function updated($property, $value)
    {
        if (in_array($property, ['department_id', 'first_name', 'last_name', 'username', 'email', 'password', 'password_confirmation'])) {
            $this->validateOnly($property);
        }

        if ($property == 'active') {
            session()->put('filter.users.active', $value);
        }

        if ($property == 'pageSize') {
            $this->resetPage();
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query() -> withCount(['roles'])
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                             ->orWhere('last_name', 'like', '%' . $this->search . '%')
                             ->orWhere('username', 'like', '%' . $this->search . '%')
                             ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            -> when($this->active == 2, function ($q) {
                return $q->onlyTrashed();
            })
            -> when($this->active == 4, function ($q) {
                return $q->withTrashed();
            })
            -> orderBy(DB::raw('LOWER('. ($this->sortField ?? 'name') .')'), ($this->sortDir ?? 'asc'))
            -> paginate($this->pageSize ?? 10);

        $this->allRoles = $this->userService->getAllRoles();

        return view('livewire.rbac.users-manager', compact('users'))
            -> layout('layout.flowbite.app');
            // ->layout('layout.first.main');
    }

    public function fillForm($user_id)
    {
        $user = User::find($user_id);

        $this -> current_user_id = $user->id;
        $this -> first_name = $user -> first_name;
        $this -> last_name = $user -> last_name;
        $this -> username = $user -> username;
        $this -> email = $user -> email;
        $this -> employee_number = $user -> employee_number;

        $this -> userRoles = $this->userService->getUserRoles($user->id);
        $this -> departments = $this->userService->getDepartmentsList();
    }

    public function resetForm()
    {
        $this -> current_user_id = null;
        $this -> first_name = '';
        $this -> last_name = '';
        $this -> username = '';
        $this -> email = '';
        $this -> employee_number = '';
        $this -> departments = [];

        // $this -> rolePermissions = [];
    }

    public function openCreateModal()
    {
        $this -> userRoles = $this->userService->getUserRoles();
        $this -> departments = $this->userService->getDepartmentsList();

        $this -> isUserModal = true;
    }

    public function openEditModal($user_id = null)
    {
        $this -> fillForm($user_id);
        $this -> isUserModal = true;
    }

    public function closeModal()
    {
        $this -> isUserModal = false;
        $this -> resetForm();
    }

    // public function save()
    // {
    //     $this->validate();

    //     $userData = [
    //         'first_name' => $this->first_name,
    //         'last_name' => $this->last_name,
    //         'username' => $this->username,
    //         'email' => $this->email,
    //     ];

    //     if ($this->password) {
    //         $userData['password'] = $this->password;
    //     }

    //     if ($this->editMode) {
    //         $user = User::findOrFail($this->userId);
    //         $user->update($userData);
    //         $this->dispatch('user-updated', name: $user->full_name);
    //     } else {
    //         $user = User::create($userData);
    //         $this->dispatch('user-created', name: $user->full_name);
    //     }

    //     $this->closeModal();
    // }


    public function saveUser()
    {
        $validated = $this -> validate();

        if($this -> current_user_id)
        {
            $user = User::find($this -> current_user_id);
            $user -> update([
                'department_id' => $validated['department_id'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'employee_number' => $validated['employee_number'],
            ]);
        }
        else
        {
            $user = User::create([
                'department_id' => $validated['department_id'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'password' => $validated['password'],
            ]);
        }

        $user -> roles() -> sync($validated['userRoles']);

        // 3. Synchronizacja uprawnień - KLUCZOWY MOMENT
        // Sprawdzamy, czy klucz 'permissions' istnieje, aby uniknąć błędów,
        // jeśli formularz może być wysłany bez żadnych uprawnień.
        // if (array_key_exists('permissions', $validated)) {
        //     $role->permissions()->sync($validated['permissions']);
        // } else {
        //     // Jeśli nie przesłano żadnych uprawnień, usuń wszystkie powiązania
        //     $role->permissions()->sync([]);
        // }

        $this -> closeModal();
    }

    public function deleteUser($user_id)
    {
        // USER CAN DELETE ANY OR DELETE OWN IF HIS
        $user = User::find($user_id);
        $user -> delete();
    }

    public function restoreUser($user_id)
    {
        // USER CAN DELETE ANY OR DELETE OWN IF HIS
        $user = User::onlyTrashed()->find($user_id);
        $user -> restore();
    }

    public function sortBy($field)
    {
        if (! in_array($field, $this->sortableFields)) return false;

        if($this->sortField === $field)
        {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        }
        else {
            $this->sortField = $field;
        }
    }
}
