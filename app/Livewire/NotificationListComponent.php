<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithPagination;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Services\NotificationService;

class NotificationListComponent extends Component
{
    use WithPagination;

    protected $sortableFields = ['title', ''];

    protected $service;

    public string $search = '';
    public int $pageSize = 10;
    public $is_read = null;

    public string $sortField = 'name';
    public string $sortDir = 'asc';

    public $current_notification_id = null;

    public bool $isPreviewDrawer = false;

    public function boot(NotificationService $service)
    {
        $this->service = $service;

        $this->is_read = session()->get('filter.notifications.is_read', null);
    }

    public function rendered()
    {
        $this->js("initFlowbite();");
    }

    // -- Walidacja w czasie rzeczywistym
    public function updated($property, $value)
    {
        // if (in_array($property, ['name'])) {
        //     $this->validateOnly($property);
        // }

        if ($property == 'is_read') {
            session()->put('filter.notifications.is_read', $value);
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
        $models = $this->service->query()
            // -> withCount(['trainings'])
            -> when($this->search, function ($query) {
                $query->where('message', 'like', '%' . $this->search . '%');
            })
            -> when($this->is_read == '0', function ($q) {
                return $q->whereNull('read_at');
            })
            -> when($this->is_read == '1', function ($q) {
                return $q->whereNotNull('read_at');
            })

            -> paginate($this->pageSize ?? 10);

        $statuses = [
            'x' => __('notifications.status.any'),
            0 => __('notifications.status.unread'),
            1 => __('notifications.status.read')
        ];

        return view('livewire.notifications', compact('models', 'statuses'))
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

    public function readToggle($notification_id)
    {
        $this->service->toggleRead($notification_id);
    }
}
