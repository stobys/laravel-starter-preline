<?php

namespace App\Services;

use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

use App\Models\ACRole;
use App\Models\ACPermission;

class RolesService
{
    public function getValidateRules($role_id = null): array
    {
        $rules = [
            'rolePermissions' => 'array',
            'rolePermissions.*' => 'exists:ac_permissions,id',
        ];

        if( $role_id )
        {
            $rules['name'] = 'required|unique:ac_roles,name,'. $role_id .'|string|min:2|max:50';
        }
        else
        {
            $rules['name'] = 'required|unique:ac_roles,name|string|min:2|max:50';
        }

        return $rules;

    }

    public function getValidateMessages(): array
    {
        return [
            'name.required' => 'Nazwa jest wymagana',
            'name.min'      => 'Nazwa musi mieć co najmniej 2 znaki',
            'name.max'      => 'Nazwa może mieć maksymalnie 50 znaków',
        ];
    }

    public function getRolePermissions($role_id = null): array
    {
        if( empty($role_id) )
        {
            return [];
        }

        $role = ACRole::find($role_id);
        $permissions = $role -> permissions -> pluck('id') -> toArray();

        return $permissions;
    }

    public function getAllPermissions(): array
    {
        $results = [];

        $permissions = ACPermission::with('resource')->get()->toArray();

        foreach( $permissions as $permission )
        {
            Arr::set($results, $permission['resource']['name'] .'.'. $permission['id'], $permission['name']);
        }

        return $results;
    }
    // public function validate(OrderCreateDTO $dto): boo
    // {
    //     // Logika walidacji zamówienia
    //     return true;
    // }

}
