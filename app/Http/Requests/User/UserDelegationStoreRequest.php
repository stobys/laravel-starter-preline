<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserDelegationStoreRequest extends FormRequest
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
			'substitute_id' => [
				'required',
				'exists:users,id',
			],
            'valid_from' => [
                'nullable',
               	Rule::date()->format('Y-m-d H:i'),
            ],
            'valid_to' => [
                'nullable',
                Rule::date()->format('Y-m-d H:i'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // 'title.required' => 'Title is required. Wymagane jest',
            // 'title.max' => 'Title must be at most 255 characters.',
            // 'cost.required' => 'Cost is required.',
            // 'cost.min' => 'Cost must be at least 0.',
            // 'starts_at.required' => 'Start date is required.',
            // 'ends_at.required' => 'End date is required.',
        ];
    }
}
