<?php

namespace App\Livewire;

use App\Models\User;

use Livewire\Component;
use App\Models\Training;
use App\DTOs\TrainingDTO;

use Livewire\WithPagination;
use App\Enums\TrainingStatus;
use App\Services\UserService;
use Livewire\WithFileUploads;
use App\Services\TrainingService;
use App\Factories\TrainingFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use SweetAlert2\Laravel\Traits\WithSweetAlert;
use App\Actions\Trainings\PrepareDTOArrayFromImportRow;

class TrainingComponent extends Component
{
    use WithPagination, WithFileUploads, WithSweetAlert;

    public $defaultColumns = [
        'id' => false,
        'title' => true,
        'provider' => false,
        'type' => false,
        'user' => true,
        'planned_date' => true,
        'planned_cost' => false,
        'status' => true,
        'actions' => true,
    ];

    public $importFile;

    public $exportColumns = [
        'id' => false,
        'title' => true,
        'provider' => false,
        'type' => true,
        'user' => true,
        'planned_date' => true,
        'planned_cost' => true,
        'status' => true,
    ];

    public array $visibleColumns = [
        'id' => false,
        'title' => true,
        'provider' => false,
        'type' => true,
        'user' => true,
        'planned_date' => true,
        'planned_cost' => false,
        'status' => true,
        'actions' => true,
    ];

    protected $sortableFields = ['title', 'provider', 'type', 'user', 'cost', 'starts_at', 'ends_at'];

    protected $service;
    protected $userService;

    public string $search = '';
    public string $state = 'all';     // 1 - active ; 2 - not active ; 4 - both
    public int $status = 0;             // 0 - any
    public string $member = 'any';     // 'any' - any ; X - id
    public int $pageSize = 10;

    public string $sortField = 'starts_at';
    public string $sortDir = 'asc';

    public $chosen = null;

    public $current_training_id = null;
    public $planned_cost = null;
    public $title = null;
    public $user = null;

    public bool $isTrainingModal = false;
    public bool $isPreviewDrawer = false;

    /**
     * Initialize the component with required services.
     */
    public function boot(TrainingService $service, UserService $userService)
    {
        $this->service = $service;
        $this->userService = $userService;

        $this->state = session()->get('filter.trainings.state', 1);
        $this->status = session()->get('filter.trainings.status', 1);
        $this->member = session()->get('filter.trainings.member', 'any');

        $this->visibleColumns = session()->get('columns.trainings', $this->defaultColumns);
    }

    /**
     * Show the import drawer
     */
    public function importFromCSV()
    {
        $this->authorize('import', Training::class);

        $this->validate($this->service->getValidateRulesForImport());

        $path = $this->importFile->store('imports');

        $rows = collect(File::lines(storage_path('app/' . $path)))
            -> filter(fn($row) => !empty(trim($row)))
            -> map(fn($row) => array_map('trim', str_getcsv($row, ';')));

        try {
            DB::transaction(function () {
                $path = $this->importFile->store('imports');

                $rows = collect(File::lines(storage_path('app/' . $path)))
                    -> filter(fn($row) => !empty(trim($row)))
                    -> map(fn($row) => array_map('trim', str_getcsv($row, ';')));

                $header = $rows->first();

                // 0 - string $title,
                // 1 - User $user,
                // 2 - int $planned_year,
                // 3 - int $planned_quarter,
                // 4 - int $planned_cost,
                // 5 - int $actual_cost,
                // 6 - string $po_number,
                // 7 - TrainingProvider $provider,
                // 8 - TrainingType $type,
                // 9 - TrainingStatus $status,

                $rows->skip(1)->each(function ($row) use ($header) {
                    $prepareAction = new PrepareDTOArrayFromImportRow;
                    $dtoArray = $prepareAction->handle($row);

                    $trainingDTO = TrainingDTO::fromArray($dtoArray);

                    (new TrainingFactory)->createFromDTO($trainingDTO);
                });

                Storage::delete($path);
                $this->reset('importFile');
                $this->importFile = null;
            });

            $this->dispatch('drawer-hide', name: 'import-trainings-drawer');

            // // Sukces
            // $this->dispatch('import-notify',
            //     type: 'success',
            //     title: 'Sukces!',
            //     message: 'Plik zaimportowany pomyślnie.',
            // );

            $this->swalFire([
                'icon'  => 'success',
                'text'  => 'Szkolenia zaimportowane pomyślnie!',

                'showConfirmButton' => false,
                'showCloseButton' => true,

                'timer' => 3000,
                'timerProgressBar' => true,
            ]);

        }
        catch (ValidationException $e) {
            // -- błędy walidacji Laravela
            $this->swalFire([
                'icon'  => 'error',
                'title' => 'Błąd walidacji',
                'text'  => $e->getMessage(),

                'showConfirmButton' => true,
                'showCloseButton' => true,
            ]);

            // $this->dispatch('import-notify',
            //     type: 'error',
            //     message: $e->getMessage(),
            //     errors: $e->errors(),
            // );
        }
        catch (\Exception $e) {
            // -- dowolny inny błąd
            $this->swalFire([
                'icon'  => 'error',
                'title' => 'Błąd importu',
                'text'  => 'Coś poszło nie tak: ' . $e->getMessage(),

                'showConfirmButton' => true,
                'showCloseButton' => true,
            ]);
        }

    }

    public function exportToCSV($separator = ';')
    {
        $csvFileName = 'trainings.csv';
        $csvFile = fopen($csvFileName, 'w');
        $csvChunk = 500; // Number of records per chunk

        $headers = collect($this->exportColumns)->filter()->keys();

        fputcsv($csvFile, $headers->toArray(), $separator);

        $models = $this->service->query()->with('user')->get();

        $export = $models->map(function ($model) use ($headers) {
            return $headers->mapWithKeys(function ($col) use ($model) {

                return match ($col) {
                    'provider' => [
                        'provider' => $model->provider->name
                    ],

                    'type' => [
                        'type' => $model->type->name
                    ],

                    'planned_date' => [
                        'planned_date' => $model->planned_fiscal_year . ' Q' . $model->planned_fiscal_quarter
                    ],

                    'user' => [
                        'user' => $model->user->full_name
                    ],

                    'status' => [
                        'status' => $model->status->name
                    ],

                    default => [$col => data_get($model, $col)],
                };

            })->toArray();
        })->toArray();

        foreach ($export as $row) {
            fputcsv($csvFile, $row, $separator);
        }

        fclose($csvFile);

        // Download the CSV file
        return Response::download(public_path($csvFileName))->deleteFileAfterSend(true);
    }

    public function rules()
    {
        return $this->service->getValidateRules($this->current_training_id);
    }

    public function messages()
    {
        return $this->service->getValidateMessages();
    }

    // -- Walidacja w czasie rzeczywistym
    public function updated($property, $value)
    {
        if (in_array($property, ['title', 'cost'])) {
            $this->validateOnly($property);
        }

        if ($property == 'state') {
            session()->put('filter.trainings.state', $value);
        }

        if ($property == 'status') {
            session()->put('filter.trainings.status', $value);
        }

        if ( str_contains($property, 'visibleColumns.') ) {
            session()->put('columns.trainings', $this->visibleColumns);
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
        // $this->authorize('manage-users');

        $models = Training::query()
            -> with('user', 'provider')

            // -- only my training or my subordinates
            -> where(function ($query) {
                    // if( ! auth()->user()->can('trainings:hr-approval') )
                    // {
                    //     $query -> whereIn('user_id', auth()->user()->subordinates()->pluck('users.id')->toArray())
                    //         -> orWhere(function ($q1) {
                    //             $q1
                    //             -> when(auth()->user()->can('trainings:fico-approval'), function ($q2) {
                    //                 return $q2->where('state', PendingFICO::class);
                    //             })
                    //             -> when(auth()->user()->can('trainings:pm-approval'), function ($q2) {
                    //                 return $q2->where('state', PendingPM::class);
                    //             });
                    //         })
                    //     ;
                    // }
            })
            // -> withCount(['users', 'permissions'])
            -> when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('title', 'like', '%' . $this->search . '%')
                            //  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                            //  ->orWhere('username', 'like', '%' . $this->search . '%')
                            //  ->orWhere('email', 'like', '%' . $this->search . '%')
                            ;
                });
            })

        -> when($this->status, function ($q) {
            return $q->where('status', $this->status);
        })
        -> when(is_numeric($this->member), function ($q) {
            return $q->where('user_id', $this->member);
        })

        -> when($this->sortField === 'user', function ($query) {
                // $query->with('user')->orderBy(DB::raw('LOWER(users.last_name)'), ($this->sortDir ?? 'asc'));
                $query
                    -> join('users', 'users.id', '=', 'trainings.user_id')
                    -> orderBy('users.last_name', ($this->sortDir ?? 'asc'));
            })

        -> when( in_array($this->sortField, ['title', 'type']), function ($query) {
                $query-> orderBy(DB::raw('LOWER('. ($this->sortField ?? 'title') .')'), ($this->sortDir ?? 'asc'));
            })
        -> when( in_array($this->sortField, ['provider', 'planned_cost']), function ($query) {
                $query-> orderBy($this->sortField, ($this->sortDir ?? 'asc'));
            })

        -> paginate($this->pageSize ?? 10);

        $teamMembers = $this->userService->getTeamMembers(true) ?? [];
        $states = $this->service->getStates() ?? [];
        $statuses = TrainingStatus::cases();
        $types = $this->service->getTypes();

        return view('livewire.trainings-manager', compact('models', 'states', 'teamMembers', 'statuses', 'types'))
            -> layout('layout.flowbite.app');
    }

    public function fillForm($training_id)
    {
        $training = Training::find($training_id);

        // $this -> current_role_id = $role->id;
        // $this -> guard_name = $role -> guard_name;
        $this -> title = $training -> title;
        $this -> planned_cost = $training -> cost;

        // $this -> rolePermissions = $this->rolesService->getRolePermissions($role->id);
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

    public function submitForApproval($training_id)
    {
        $training = Training::findOrFail($training_id);

        if( ! $this->authorize('submitForApproval', $training) )
        {
            abort(403, 'User Not Unauthorized To Submit Training For Approval!');
        }

        try {
            $training -> state -> transitionTo(PendingDM::class);
            $training -> save();
        }
        catch(TransitionNotFound $e)
        {
            abort(405, 'Transition not allowed!');
        }
    }

    public function withdraw($training_id)
    {
        $training = Training::findOrFail($training_id);

        try {
            $training -> state -> transitionTo(Withdrawn::class);
            $training -> save();
        }
        catch(TransitionNotFound $e)
        {
            abort(405, 'Transition not allowed!');
        }
    }

    public function revertToDraft($training_id)
    {
        $training = Training::findOrFail($training_id);

        try {
            $training -> state -> transitionTo(Draft::class);
            $training -> save();
        }
        catch(TransitionNotFound $e)
        {
            abort(405, 'Transition not allowed!');
        }
    }

    public function deleteTraining($training_id)
    {
        // USER CAN DELETE ANY OR DELETE OWN IF HIS
        $training = Training::findOrFail($training_id);
        $training -> delete();
    }

    public function restoreTraining($training_id)
    {
        // USER CAN DELETE ANY OR DELETE OWN IF HIS
        $training = Training::onlyTrashed()->findOrFail($training_id);
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


    public function markAsRealized($training_id)
    {
        $training = Training::find($training_id);

        if (!$training) {
            abort(404, 'Training not found!');
        }

        $training -> status = TrainingStatus::REALIZED;
        $training -> save();
    }

    public function markAsEvaluated($training_id)
    {
        $training = Training::find($training_id);

        if (!$training) {
            abort(404, 'Training not found!');
        }

        $training -> status = TrainingStatus::EVALUATED;
        $training -> save();
    }

    public function uploadAttachments()
    {

    }
}
