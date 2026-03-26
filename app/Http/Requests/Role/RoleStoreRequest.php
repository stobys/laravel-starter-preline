<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Validation\Rule;
// use Illuminate\Validation\Rules\Password;

class RoleStoreRequest extends FormRequest
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
            'name' => ['required', 'unique:ac_roles'],
            'permissions'   => 'array',
            'permissions.*' => 'exists:ac_permissions,id',
        ];
    }

}
