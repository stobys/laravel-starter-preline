<?php

namespace App\Actions\Department;

use App\Models\Department;

class DestroyDepartment
{
    public function handle(Department $department): bool
    {
        return $department->delete();
    }
}
