<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\DepartmentDeleteRequest;
use App\Http\Requests\Department\DepartmentImportRequest;
use App\Http\Requests\Department\DepartmentStoreRequest;
use App\Http\Requests\Department\DepartmentUpdateRequest;
use App\Models\Department;
use App\Models\User;
use App\Services\Filters\DepartmentFiltersService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function __construct(
        // protected DepartmentService $service
    ) {}

    public function index(DepartmentFiltersService $filters)
    {
        $departments = $filters->apply()->applySort()->paginate( config('app.paginator.items_per_page') );

        return view('departments.index', compact('departments'));
    }

    public function filter(Request $request, DepartmentFiltersService $filters)
    {
        $filters->save($request->only('filters'));
        return redirect()->route('departments.index');
    }

    public function create(Department $department)
    {
        // $this->authorize('create', Department::class);
		$users = User::select('id', 'full_name')->get();
		$action = 'create';

        return view('departments.create', compact('department', 'action', 'users'));
    }

    public function store(DepartmentStoreRequest $request)
    {
        $department = Department::create($request->validated());

        return redirect()->route('departments.index') -> with('success', 'CREATED!');
    }

    public function edit(Department $department)
    {
        // $this->authorize('update', $department);
		$action = 'edit';
		$users = User::select('id', 'full_name')->get();

        return view('departments.edit', compact('department', 'action', 'users'));
    }

    public function update(DepartmentUpdateRequest $request, Department $department)
    {
        $data = $request->validated();
        $department->update($data);

        return redirect()->route('departments.index')->with('success', 'UPDATED!');
    }

    public function delete(DepartmentDeleteRequest $request, Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'DELETED!');
    }

    public function restore(Department $department)
    {
        if ($department->restore()) {
            // flash('element-delete-confirmation', 'element usuniety');
        }

        return redirect()->route('departments.index');
    }

    public function import(DepartmentImportRequest $request)
    {
		collect(Arr::get($request->validated(), 'departments', null))
			-> map(function($row){
				Department::updateOrCreate(['abbr' => $row['abbr']], $row);
			});

        return redirect()->route('departments.index')->with('success', 'IMPORTED!');
    }

    // Widok pojedynczego szkolenia
    // public function show(Department $department)
    // {
    //     $this->authorize('view', $department);
    //     // $department->load('type', 'approvals.approver');
    //     return view('departments.show', compact('department'));        return view('departments.details', compact('department'));
    // }

	public function syncTeta()
	{
		// -- test bazy
		try {
			DB::connection('oracle')->getPdo();

			// -- Wywołaj komendę synchronicznie
			Artisan::call('sync:teta', ['model' => 'department']);

		} catch (\Exception $e) {
			dd($e, $e->getMessage());

			abort(503, 'Baza TETA jest niedostępna');
		}

        return redirect()->back();
	}
}
