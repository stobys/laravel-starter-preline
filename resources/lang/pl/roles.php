<?php

return [
    'labels'    => [
        'index-title'        => 'Role',
        'index-title-helper' => 'Lista Ról',
        'create-title'        => 'Role: Tworzenie',
        'create-title-helper' => 'Formularz tworzenia roli',
        'edit-title'        => 'Role: Edycja',
        'edit-title-helper' => 'Formularz edycji roli',
		'import-title'			=> 'Importowanie Ról',
		'import-title-helper'	=> 'Formularz importowania ról',
		'validation-errors-title' => 'Wystąpiły błędy walidacji', // There are some validation errors.'

		'role-info-tab'				=> 'Informacje',
		'role-permissions-tab'		=> 'Uprawnienia',

		'resource-rbac'		=> 'RBAC',
		'resource-users'		=> 'Użytkownicy',
    ],

	'permissions'	=> [
		'rbac:manage-roles'	=> 'Zarządzanie Rolami',
		'rbac:manage-users'	=> 'Zarządzanie Użytkownikami',

		'users:list:any'			=> 'Listowanie',
		'users:create'				=> 'Tworzenie',
		'users:edit:any'			=> 'Edycja',
		'users:delete:any'			=> 'Usuwanie',
		'users:restore:any'			=> 'Przywracanie',
		'users:force-delete:any'	=> 'Permanentne usuwanie',
	],

    'actions' => [
        'add-new' => 'Dodaj Role',
    ],

    'th' => [
        'id' 	=> 'ID',
        'name'	=> 'Nazwa',
        'status'	=> 'Status',
        'stats'	=> 'Statystyki',
        'permissions'	=> 'Uprawnienia',
        'created_at'	=> 'Data Utworzenia',
    ],

];
