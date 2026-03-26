<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
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
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'password' => [
                'sometimes',
                'nullable',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    // ->symbols()
                    // ->uncompromised()
            ],
            'roles'   => 'array',
            'roles.*' => 'exists:ac_roles,id',
        ];
    }

    public function rulesRequiredIf(): array
    {
        return [
            'action' => 'required|in:draft,submit',

            // Wymagane TYLKO jeśli action === 'save'
            'name' => 'required_if:action,submit|nullable|string|max:255',
            'code' => 'required_if:action,submit|nullable|string|max:50|unique:departments,code',
            'budget' => 'required_if:action,submit|nullable|numeric|min:0',
            'location' => 'required_if:action,submit|nullable|string|max:100',

            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required. Wymagane jest',
            'title.max' => 'Title must be at most 255 characters.',
            'cost.required' => 'Cost is required.',
            'cost.min' => 'Cost must be at least 0.',
            'starts_at.required' => 'Start date is required.',
            'ends_at.required' => 'End date is required.',
        ];
    }
}
