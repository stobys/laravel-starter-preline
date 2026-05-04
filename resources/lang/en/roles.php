<?php

return [
    'labels'    => [
        'index-title'        => 'Roles',
        'index-title-helper' => 'Roles List',
        'create-title'        => 'Roles: Create',
        'create-title-helper' => 'Role Create Form',
        'edit-title'        => 'Roles: Edit',
        'edit-title-helper' => 'Role Edit Form',
		'import-title'			=> 'Roles: Import',
		'import-title-helper'	=> 'Roles Import Form',
		'validation-errors-title' => 'There are some validation errors', // There are some validation errors.'

		'role-info-tab'				=> 'General Info',
		'role-permissions-tab'		=> 'Permissions',

		'resource-rbac'		=> 'RBAC',
		'resource-users'		=> 'Users',
    ],

	'permissions'	=> [
		'rbac:manage-roles'	=> 'Roles Management',
		'rbac:manage-users'	=> 'Users Management',

		'users:list:any'			=> 'List',
		'users:create'				=> 'Create',
		'users:edit:any'			=> 'Edit',
		'users:delete:any'			=> 'Delete',
		'users:restore:any'			=> 'Restore',
		'users:force-delete:any'	=> 'Permanent Delete',
	],

    'actions' => [
        'add-new' => 'Add Role',
    ],

    'th' => [
        'id' 	=> 'ID',
        'name'	=> 'Name',
        'status'	=> 'Status',
        'stats'	=> 'Stats',
        'permissions'	=> 'Permissions',
        'created_at'	=> 'Creation Date',
    ],

];
