<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
// use App\Models\Department;

class DepartmentDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $department = $this->route('department');

        if ( $department->members()->exists() ) {
            // -- department has members, cannot be deleted
            return false;
        }

		return true;
        return $this->user()->can('destroy', $department);
    }

    public function rules(): array
    {
        return [];
    }
}
