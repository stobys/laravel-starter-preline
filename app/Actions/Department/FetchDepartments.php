<?php

namespace App\Actions\Department;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use App\Filters\DepartmentFilter;
use App\Models\Department;

class FetchDepartments
{
    public function handle(DepartmentFilter $filter, int $perPage = 10): LengthAwarePaginator
    {
        return Department::filter($filter)->paginate($perPage)->withQueryString();
    }

    public function handleOld(DepartmentFilter $filters)
    {
        $query = Department::filter($filters);
        return $query->paginate(10);
    }
}
