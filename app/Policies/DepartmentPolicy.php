<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Department;

class DepartmentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        // dd('DepartmentPolicy constructor');
    }

    /**
     * Determine whether the user can update the training.
     */
    public function create(User $user): bool
    {
        return $user->isAlmighty();
    }

    /**
     * Determine whether the user can update the training.
     */
    public function update(User $user, Department $department): bool
    {
        return $user->isAlmighty();
    }

    /**
     * Determine whether the user can delete the training.
     */
    public function destroy(User $user, Department $department): bool
    {
        return $department->members()->count() === 0;
        // return $user->isAlmighty() && $department->members()->count() === 0;
    }

    /**
     * Determine whether the user can reject the training.
     */
    public function show(User $user, Department $department): bool
    {
        return true;

    }
}
