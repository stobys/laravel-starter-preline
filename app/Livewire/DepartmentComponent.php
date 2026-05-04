<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Department;
use Illuminate\Support\Arr;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Services\DepartmentService;

class DepartmentComponent extends Component
{
    use WithPagination;

    protected $sortableFields = ['name', 'abbr'];

    protected $service;

    public array $previewDrawer = [];

    public string $search = '';
    public string $state = 'all';     // 1 - active ; 2 - not active ; 4 - both
    public int $pageSize = 10;

    public string $sortField = 'name';
    public string $sortDir = 'asc';

    public $chosen = null;
    public $current_department_id = null;

    public $active = 1;
    public $name = null;
    public $abbr = null;
    public $manager_id = null;

    public bool $isDepartmentModal = false;
    public bool $isPreviewDrawer = false;

    public function boot(DepartmentService $service)
    {
        $this->service = $service;

        $this->fillPreviewDrawer();

        $this->active = session()->get('filter.departments.active', 1);
    }

    public function rendered()
    {
        $this->js("initFlowbite();");
    }

    public function rules()
    {
        return $this->service->getValidateRules($this->current_department_id);
    }

    public function messages()
    {
        return $this->service->getValidateMessages();
    }

    // -- Walidacja w czasie rzeczywistym
    public function updated($property, $value)
    {
        if (in_array($property, ['name', 'abbr', 'manager_id'])) {
            $this->validateOnly($property);
        }

        if ($property == 'state') {
            session()->put('filter.departments.state', $value);
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
        $models = Department::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                             ->orWhere('abbr', 'like', '%' . $this->search . '%');
            })
            -> when( in_array($this->sortField, ['name', 'abbr']), function ($query) {
                    $query-> orderBy(DB::raw('LOWER('. ($this->sortField ?? 'name') .')'), ($this->sortDir ?? 'asc'));
                })

            -> withCount('members')
            -> paginate($this->pageSize ?? 10);

        return view('livewire.departments', compact('models'))
            -> layout('layout.flowbite.app');
    }

    public function fillForm($modelId)
    {
        $model = Department::find($modelId);

        $this -> name = $model -> name;
        $this -> abbr = $model -> abbr;
        $this -> manager_id = $model -> manager_id;
    }

    public function resetForm()
    {
        // $this -> current_department_id = null;
        // $this -> guard_name = 'web';
        // $this -> name = '';

        // $this -> rolePermissions = [];
    }

    public function openCreateModal()
    {
        // $this -> isRoleModal = true;
    }

    public function openEditModal($modelId = null)
    {
        // $this -> fillForm($modelId);
        // $this -> isRoleModal = true;
    }

    public function closeModal()
    {
        // $this -> isRoleModal = false;
        // $this -> resetForm();
    }

    public function openPreviewDrawer($model_id)
    {
        $this->fillPreviewDrawer($model_id);

        $this->js('showPreviewDrawer()');
    }

    public function destroy($modelId)
    {
        $model = Department::findOrFail($modelId);

        $this->authorize('destroy', $model);

        $this->service->destroy($model);
    }

    public function restore($modelId)
    {
        // USER CAN DELETE ANY OR DELETE OWN IF HIS
        $model = Department::onlyTrashed()->findOrFail($modelId);
        $this->service->restore($model);
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

    public function exportToCSV($separator = ';') {
        $csvFileName = $this->service->getExportFileName();
        $csvFile = fopen($csvFileName, 'w');
        $csvChunk = 500; // Number of records per chunk

        fputcsv($csvFile, ['name', 'abbr', 'manager'], $separator);

        // $trainings = Training::all();
        $this->service->query()->select('name', 'abbr', 'manager_id')
            ->chunk($csvChunk, function ($models) use ($csvFile, $separator) {
               // Process each chunk of results
                $models->each(
                    fn($row) => fputcsv($csvFile, [$row->name, $row->abbr, $row->manager->full_name], $separator)
                );
            });

        fclose($csvFile);

        // Download the CSV file
        return Response::download(public_path($csvFileName))->deleteFileAfterSend(true);
    }

    protected function fillPreviewDrawer($model_id = null)
    {
        if ($model_id === null) {
            $this -> previewDrawer['name'] = '';
            $this -> previewDrawer['abbr'] = '';
            $this -> previewDrawer['manager'] = '';
        }
        else {
            $model = Department::find($model_id);

            $this -> previewDrawer['name'] = $model -> name;
            $this -> previewDrawer['abbr'] = $model -> abbr;
            $this -> previewDrawer['manager'] = $model -> manager -> full_name;
        }
    }
}
