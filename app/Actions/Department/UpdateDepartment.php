<?php

namespace App\Actions\Department;

use App\Models\Department;

class UpdateDepartment
{
    public function handle(Department $department, array $data): Department
    {
        $department->update($data);

        return $department->refresh();
    }
}
