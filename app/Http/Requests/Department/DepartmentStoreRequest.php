<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Validation\Rule;

class DepartmentStoreRequest extends FormRequest
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
        return [
            'name' 			=> ['required', 'unique:departments'],
            'manager_id'	=> ['nullable', 'exists:users,id'],
            'display_name'	=> ['nullable', 'unique:departments'],
            'abbr' 			=> ['nullable', 'unique:departments'],
            'teta_mpk_code'	=> ['nullable', 'unique:departments'],
        ];
    }
}
