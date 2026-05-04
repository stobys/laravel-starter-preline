<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Department;

class DepartmentUpdateRequest extends FormRequest
{
    // -- Determine if the user is authorized to make this request.
    public function authorize(): bool
    {
        // -- @TODO : anyone can create, but only self can update and delete
        // -- @TODO : admin can approve and reject
        return true; // every user can create trainings, that's the point of this app
    }

    // public function authorize(
    //     #[RouteParameter('training')] Training $training
    // ): bool {
    //     return $training->user->is($this->user());
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $department = $this->route('department');

        return [
            'name' => [
                'required',
                Rule::unique(Department::getTableName(), 'name')->ignore($department->id)
            ],
			'manager_id'	=> ['nullable', 'exists:users,id'],
            'display_name' => [
                'nullable',
                Rule::unique(Department::getTableName(), 'display_name')->ignore($department->id)
            ],
            'teta_mpk_code' => [
                'nullable',
                Rule::unique(Department::getTableName(), 'teta_mpk_code')->ignore($department->id)
            ],
            'abbr' => [
                'nullable',
                Rule::unique(Department::getTableName(), 'abbr')->ignore($department->id)
            ],

        ];
    }
}
