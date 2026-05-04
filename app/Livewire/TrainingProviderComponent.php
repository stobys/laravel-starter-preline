<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithPagination;

use App\Models\TrainingProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Services\TrainingProviderService;

class TrainingProviderComponent extends Component
{
    use WithPagination;

    protected $sortableFields = ['name'];

    protected $service;

    public string $search = '';
    public string $state = 'all';     // 1 - active ; 2 - not active ; 4 - both
    public int $pageSize = 10;

    public string $sortField = 'name';
    public string $sortDir = 'asc';

    public $current_provider_id = null;

    public $is_active = 1;
    public $name = null;
    public $address = null;
    public $description = null;

    public bool $isTrainingModal = false;
    public bool $isPreviewDrawer = false;

    public function boot(TrainingProviderService $service)
    {
        $this->service = $service;

        $this->is_active = session()->get('filter.training_providers.is_active', 0);
    }

    public function rendered()
    {
        $this->js("initFlowbite();");
    }

    public function rules()
    {
        return $this->service->getValidateRules($this->current_provider_id);
    }

    public function messages()
    {
        return $this->service->getValidateMessages();
    }

    // -- Walidacja w czasie rzeczywistym
    public function updated($property, $value)
    {
        if (in_array($property, ['name'])) {
            $this->validateOnly($property);
        }

        if ($property == 'is_active') {
            session()->put('filter.training_providers.is_active', $value);
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
        $models = TrainingProvider::query()
            -> withCount(['trainings'])
            -> when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                             ->orWhere('address', 'like', '%' . $this->search . '%')
                             ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            -> when( in_array($this->sortField, ['name', 'address', 'description']), function ($query) {
                    $query-> orderBy(DB::raw('LOWER('. ($this->sortField ?? 'name') .')'), ($this->sortDir ?? 'asc'));
                })
            -> when($this->is_active == 1, function ($q) {
                return $q->where('is_active', true);
            })
            -> when($this->is_active == 2, function ($q) {
                return $q->where('is_active', false);
            })

            -> paginate($this->pageSize ?? 10);

        $statuses = [
            0 => __('training_providers.status.any'),
            1 => __('training_providers.status.active'),
            2 => __('training_providers.status.inactive')
        ];

        return view('livewire.training-providers', compact('models', 'statuses'))
            -> layout('layout.flowbite.app');
    }

    public function fillForm($model_id)
    {
        $model = TrainingProvider::find($model_id);

        $this -> name = $model -> name;
        $this -> address = $model -> address;
        $this -> description = $model -> description;
    }

    public function resetForm()
    {
        // $this -> current_role_id = null;
        // $this -> guard_name = 'web';
        // $this -> name = '';

        // $this -> rolePermissions = [];
    }

    public function openCreateModal()
    {
        // $this -> isRoleModal = true;
    }

    public function openEditModal($role_id = null)
    {
        // $this -> fillForm($role_id);
        // $this -> isRoleModal = true;
    }

    public function closeModal()
    {
        // $this -> isRoleModal = false;
        // $this -> resetForm();
    }

    public function openPreviewDrawer($training_id)
    {
        $this -> fillForm($training_id);

        $this->js('showPreviewDrawer()');
    }

    public function deleteTraining($training_id)
    {
        // USER CAN DELETE ANY OR DELETE OWN IF HIS
        $training = TrainingProvider::find($training_id);
        $training -> delete();
    }

    public function restoreTraining($training_id)
    {
        // USER CAN DELETE ANY OR DELETE OWN IF HIS
        $training = TrainingProvider::onlyTrashed()->find($training_id);
        $training -> restore();
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

        fputcsv($csvFile, ['name', 'address', 'description'], $separator);

        // $trainings = Training::all();
        $this->service->query()->select('name')
            ->chunk($csvChunk, function ($trainings) use ($csvFile, $separator) {
               // Process each chunk of results
                $trainings->each(
                    fn($row) => fputcsv($csvFile, [$row->name, $row->address, $row->description], $separator)
                );
            });

        fclose($csvFile);

        // Download the CSV file
        return Response::download(public_path($csvFileName))->deleteFileAfterSend(true);
    }

    public function activeToggle(int $provider_id)
    {
        $provider = TrainingProvider::findOrFail($provider_id);

        $this->service->toggleActivity($provider);
    }

}
