<?php

namespace App\Http\Requests\Department;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DepartmentImportRequest extends FormRequest
{
    // -- Determine if the user is authorized to make this request.
    public function authorize(): bool
    {
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
            'departments' 			=> 'required|array',
            // 'departments.*.name' 	=> 'required|string',
            // 'departments.*.abbr' 	=> 'required|string',
            'departments.*.name' 	=> 'required|string|unique:departments,name',
            'departments.*.abbr' 	=> 'nullable|string|unique:departments,abbr',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'departments' => collect(preg_split('/\r\n|\r|\n/', $this->departments))
                -> filter()
                -> map(function ($line) {
						[$name, $abbr] = array_map('trim', explode(';', $line));

						return [
							'name' => $name,
							'abbr'  => $abbr,
						];
					})
                -> filter(fn($item) => filled($item['name']) && filled($item['abbr']))
                -> values()
                -> toArray()
        ]);
    }

	public function messages()
	{
		return [
			'departments.*.name.required' => 'Nazwa działu w linii :index jest wymagana',
			'departments.*.abbr.unique' => 'Skrót :input w linii :index już istnieje',
			'departments.*.abbr.size' => 'Skrót w linii :index musi mieć dokładnie 3 znaki',
		];
	}
}
