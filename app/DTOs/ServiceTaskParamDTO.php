<?php

namespace App\DTOs;

final class ServiceTaskParamDTO extends BaseDTO
{

    public function __construct(
        public readonly string $label,
        public readonly string $type,
        public readonly string $name,
        public readonly mixed $value,
		public readonly ?bool $required = false,
    ) {
        // parent::__construct();
    }

    /**
     * Standardowe reguły Laravela.
     */
    protected static function rules(): array
    {
        return [
            'label'                  => ['required', 'string', 'max:255'],
            'type'                   => ['required', 'in:text,password,radio,checkbox,select'],
            'name'    				 => ['required', 'string'],
            'value' 				 => ['nullable'],
            'required' 				 => ['nullable', 'boolean'],
        ];
    }

    protected static function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            // ... jeśli chcesz
        ];
    }

    protected static function attributes(): array
    {
        return [
            'po_number' => 'PO number',
        ];
    }

}
