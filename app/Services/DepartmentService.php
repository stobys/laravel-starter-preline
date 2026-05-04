<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Support\Str;
use App\Actions\Department\StoreDepartment;
use App\Actions\Department\DestroyDepartment;
use App\Actions\Department\UpdateDepartment;

class DepartmentService
{

    public function __construct(
        private readonly StoreDepartment $storeAction,
        private readonly UpdateDepartment $updateAction,
        private readonly DestroyDepartment $destroyAction
    ) {}

    public function query($with_filter = false) {
        return Department::query();
    }

    public function store(array $data)
    {
        $model = $this->storeAction->handle($data);

        return [
            'errno' => $model->exists ? 0 : 1,
            'errmsg' => $model->exists ? 'Department saved successfully' : 'Department not saved',
            'model' => $model
        ];
    }

    public function update(Department $model, array $data)
    {
        $model = $this->updateAction->handle($model, $data);

        // $training->logStateTransition($data['state']);

        return [
            'errno' => $model->exists ? 0 : 1,
            'errmsg' => $model->exists ? 'Department saved successfully' : 'Department not saved',
            'model' => $model
        ];
    }

    public function destroy(Department $model)
    {
        $isDeleted = $this->destroyAction->handle($model);

        // $training->logStateTransition($data['state']);

        return [
            'errno' => $isDeleted ? 0 : 1,
            'errmsg' => $isDeleted ? 'Department deleted successfully' : 'Department not deleted',
            'model' => null
        ];
    }

    // public function restore($model, $user)
    // {
    //     $model = $this->restoreAction->handle($model, $user);

    //     // $training->logStateTransition($data['state']);

    //     return [
    //         'errno' => $model->exists ? 0 : 1,
    //         'errmsg' => $model->exists ? 'Department deleted successfully' : 'Department not deleted',
    //         'model' => $model
    //     ];
    // }

    public function getExportFileName()
    {
        $baseName = Str::studly(Department::getTableName());
        return sprintf('%s-%s.csv', $baseName, now()->format('YmdHis'));
    }
}
