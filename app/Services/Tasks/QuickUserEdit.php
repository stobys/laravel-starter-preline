<?php

namespace App\Services\Tasks;

use App\DTOs\ServiceTaskParamDTO;
use App\Models\User;
use App\Services\Tasks\BaseServiceTask;
use App\Services\Tasks\TaskResult;
use Illuminate\Support\Arr;

class QuickUserEdit extends BaseServiceTask
{
    public function name(): string { return __('QuickUserEdit'); }
    public function description(): string { return __('Quickly edit users'); }

    public function parameters(): array
    {
        return [
			'username'	=> ServiceTaskParamDTO::make(
							label: 'Username',
							type: 'text',
							name: 'username',
							value: null,
							required: true,
						),

			'password'	=> ServiceTaskParamDTO::make(
							label: 'Password',
							type: 'password',
							name: 'password',
							value: null,
							required: false,
						),

			'is_domain_user' => ServiceTaskParamDTO::make(
								label: 'Is Domain User',
								type: 'checkbox',
								name: 'is_domain_user',
								value: '1',
								required: false,
							),
        ];
    }

    public function run(array $fields = []): TaskResult
    {
        $username = Arr::get($fields, 'username', null);
        $password = Arr::get($fields, 'password', null);
        $is_domain = (bool) Arr::get($fields, 'is_domain_user', false);

		$user = User::where('username', $username)->first();
		if( ! $user ) {
        	return TaskResult::fail('Nie znaleziono usera `'. $username .'` w bazie.');
		}

		$user -> update(['is_domain_user' => $is_domain ? 1 : 0]);

		if( $password ) {
			$user -> update(['password' => bcrypt($password)]);
		}

        return TaskResult::ok('Uzytkownik edytowany.');
    }
}
