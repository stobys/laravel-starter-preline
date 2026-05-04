<?php

namespace App\Actions\Department;

use App\Models\Department;

class StoreDepartment
{
    public function handle(array $data): Department
    {
        return Department::create($data);
    }
}
