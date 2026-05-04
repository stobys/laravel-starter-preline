<?php

return [
    'labels'    => [
        'index-title'        		=> 'Users',
        'index-title-helper' 		=> 'Users List',
        'create-title'        		=> 'Users: Create',
        'create-title-helper' 		=> 'User Create Form',
        'edit-title'        		=> 'Users: Edit',
        'edit-title-helper' 		=> 'User Edit Form',
        'show-title'        		=> 'Users: Preview',
        'show-title-helper' 		=> 'User Preview',
		'import-title'				=> 'Users: Import',
		'import-title-helper'		=> 'Users Import Form',
		'settings-title'			=> 'User Settings',
		'settings-title-helper'		=> 'User Settings Form',
		'validation-errors-title'	=> 'There are some validation errors', // There are some validation errors.'

		'password-divider'			=> 'Password (optional)',
    ],

    'actions' => [
        'add-new' 		=> 'Add User',
        'sync-teta' 	=> 'Synchronize with TETA',
		'syncing-teta'	=> 'Synchronizing ...',

        'sync-ldap' 	=> 'Synchronize with AD',
		'syncing-ldap'	=> 'Synchronizing ...',

		'impersonate-take'	=> 'Start Impersonating',
		'impersonate-leave'	=> 'Stop Impersonating',

    ],

    'th' => [
        'id' 					=> 'ID',
        'department'			=> 'Department',
        'manager'				=> 'Direct Manager',
        'username'				=> 'Global ID',
        'email'					=> 'Email',
        'first-name'			=> 'First Name',
        'last-name'				=> 'Last Name',
        'name'					=> 'Name',
        'status'				=> 'Status',
        'roles'					=> 'Roles',
        'password-age'			=> 'Password Age',
        'password'				=> 'Password',
        'password-confirmation'	=> 'Password Confirmation',
        'created_at'			=> 'Creation Date',
    ],

	'validation'	=> [
		'own-manager'	=> 'User cannot be their own manager',
	],

];
