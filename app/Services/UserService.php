<?php

namespace App\Services;

use App\Models\User;
use App\Models\ACRole;
use App\Models\Department;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UserService
{
    public function getValidateRules($user_id = null): array
    {
        $departmentsTableName = Department::getTableName();
        $usersTableName = User::getTableName();

        $rules = [
            'userRoles' => 'array',
            'userRoles.*' => 'exists:ac_roles,id',

            'department_id' => 'nullable|exists:' . $departmentsTableName . ',id',
            // 'manager_id' => 'nullable|exists:' . $usersTableName . ',id',
            'employee_number' => 'nullable|integer|min:1',
            'first_name' => 'required|string|min:2|max:50',
            'last_name' => 'required|string|min:2|max:50',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'alpha_dash',
                // 'unique:users,username,'. $user_id,
                Rule::unique('users')->ignore($user_id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                // 'unique:users,email,'. $user_id,
                Rule::unique('users')->ignore($user_id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password',
        ];

        return $rules;

    }

    public function getValidateMessages(): array
    {
        return [
            // 'first_name.required' => 'Imię jest wymagane.',
            // 'first_name.min' => 'Imię musi mieć co najmniej 2 znaki.',
            // 'last_name.required' => 'Nazwisko jest wymagane.',
            // 'last_name.min' => 'Nazwisko musi mieć co najmniej 2 znaki.',
            // 'username.required' => 'Nazwa użytkownika jest wymagana.',
            // 'username.unique' => 'Ta nazwa użytkownika jest już zajęta.',
            // 'username.alpha_dash' => 'Nazwa użytkownika może zawierać tylko litery, cyfry, myślniki i podkreślenia.',
            // 'email.required' => 'Email jest wymagany.',
            // 'email.email' => 'Podaj prawidłowy adres email.',
            // 'email.unique' => 'Ten email jest już zarejestrowany.',
            // 'password.required' => 'Hasło jest wymagane.',
            // 'password.min' => 'Hasło musi mieć co najmniej 8 znaków.',
            // 'password.confirmed' => 'Potwierdzenie hasła nie pasuje.',
        ];
    }

    public function getUserRoles($user_id = null): array
    {
        if( empty($user_id) )
        {
            return [];
        }

        $user = User::find($user_id);
        $roles = $user -> roles -> pluck('id') -> toArray();

        return $roles;
    }

    public function getAllRoles(): array
    {
        $results = [];

        $roles = ACRole::get()->toArray();

        foreach( $roles as $role )
        {
            Arr::set($results, $role['id'], $role['name']);
        }

        return $results;
    }

    public function getTeamMembers($with_user = false): array
    {
        $subordinates = auth()->user()->subordinates()->pluck('username', 'users.id')->toArray();
        $results = [];

        if($with_user) {
            Arr::set($results, auth()->user()->id, auth()->user()->username);
        }

        $results += $subordinates;

        return $results;
    }

    public function getDepartmentsList(): array
    {
        $departments = Department::select('id', 'name', 'abbr')->get();

        return $departments->mapWithKeys(function ($dept) {
            return [$dept->id => sprintf('%s - %s', $dept->abbr, $dept->name)];
        })->toArray();
    }
}
