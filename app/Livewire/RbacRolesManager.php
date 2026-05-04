<?php

namespace App\Livewire;

use App\Models\ACRole;
use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use App\Services\RolesService;
use Illuminate\Support\Facades\DB;

class RbacRolesManager extends Component
{
    use WithPagination;

    protected $sortableFields = ['name', 'guard_name'];

    protected $rolesService;

    // protected $queryString = ['activeTab' => ['except' => 'roles']];

    public string $search = '';
    public int $pageSize = 10;
    public int $active = 1;     // 1 - active ; 2 - not active ; 4 - both

    public string $sortField = 'name';
    public string $sortDir = 'asc';

    public $current_role_id = null;

    public array $rolePermissions = [];
    public array $allPermissions = [];

    public string $guard_name = 'web';
    public string $name = '';

    public bool $isRoleModal = false;

    public function boot(RolesService $rolesService)
    {
        $this->authorize('rbac:manage-users');

        $this->rolesService = $rolesService;

        $this->active = session()->get('filter.roles.active', 1);
    }

    public function rules()
    {
        return $this->rolesService->getValidateRules($this->current_role_id);
    }

    public function messages()
    {
        return $this->rolesService->getValidateMessages();
    }

    // -- Walidacja w czasie rzeczywistym
    public function updated($property, $value)
    {
        if (in_array($property, ['name'])) {
            $this->validateOnly($property);
        }

        if ($property == 'active') {
            session()->put('filter.roles.active', $value);
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

        $roles = ACRole::query()
            -> withCount(['users', 'permissions'])
            -> when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%' . $this->search . '%')
                            //  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                            //  ->orWhere('username', 'like', '%' . $this->search . '%')
                            //  ->orWhere('email', 'like', '%' . $this->search . '%')
                            ;
                });
            })

        // -> when($this->active == 1, function ($q) {
        //     // return $q->where('likes', '>', request('likes_amount', 0));
        // })
        -> when($this->active == 2, function ($q) {
            return $q->onlyTrashed();
        })
        -> when($this->active == 4, function ($q) {
            return $q->withTrashed();
        })
        -> orderBy(DB::raw('LOWER('. ($this->sortField ?? 'name') .')'), ($this->sortDir ?? 'asc'))
        -> paginate($this->pageSize ?? 10);

        $this->allPermissions = $this->rolesService->getAllPermissions();

        return view('livewire.rbac.roles-manager', compact('roles'))
            -> layout('layout.flowbite.app');
    }

    public function fillForm($role_id)
    {
        $role = ACRole::find($role_id);

        $this -> current_role_id = $role->id;
        $this -> guard_name = $role -> guard_name;
        $this -> name = $role -> name;

        $this -> rolePermissions = $this->rolesService->getRolePermissions($role->id);
    }

    public function resetForm()
    {
        $this -> current_role_id = null;
        $this -> guard_name = 'web';
        $this -> name = '';

        $this -> rolePermissions = [];
    }

    public function openCreateModal()
    {
        $this -> isRoleModal = true;
    }

    public function openEditModal($role_id = null)
    {
        $this -> fillForm($role_id);
        $this -> isRoleModal = true;
    }

    public function closeModal()
    {
        $this -> isRoleModal = false;
        $this -> resetForm();
    }

    public function saveRole()
    {
        $validated = $this -> validate();

        if($this -> current_role_id)
        {
            $role = ACRole::find($this -> current_role_id);
            $role -> update([
                'guard_name' => $this -> guard_name,
                'name' => $this -> name,
            ]);
        }
        else
        {
            $role = ACRole::create([
                'name' => $validated['name'],
            ]);
        }

        $role -> permissions() -> sync($validated['rolePermissions']);

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

    public function deleteRole($role_id)
    {
        // USER CAN DELETE ANY OR DELETE OWN IF HIS
        $role = ACRole::find($role_id);
        $role -> delete();
    }

    public function restoreRole($role_id)
    {
        // USER CAN DELETE ANY OR DELETE OWN IF HIS
        $role = ACRole::onlyTrashed()->find($role_id);
        $role -> restore();
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
