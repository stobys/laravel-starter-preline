<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ACRole;
use App\Models\ACResource;
use App\Models\ACPermission;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RBACSeeder extends Seeder
{
    public function run()
    {
        $this -> seedSpatieRolesAndPermissions();
    }

    public function seedSpatieRolesAndPermissions()
    {
        ACResource::create(['name' => 'rbac']);
        ACResource::create(['name' => 'users']);
        ACResource::create(['name' => 'trainings']);

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        ACPermission::create(['resource_id' => 1, 'name' => 'rbac:manage-roles']);
        ACPermission::create(['resource_id' => 1, 'name' => 'rbac:manage-users']);
        ACPermission::create(['resource_id' => 1, 'name' => 'rbac:hr-representative']);
        ACPermission::create(['resource_id' => 1, 'name' => 'rbac:hr-manager']);

        ACPermission::create(['resource_id' => 2, 'name' => 'users:list:any']);
        ACPermission::create(['resource_id' => 2, 'name' => 'users:create']);
        ACPermission::create(['resource_id' => 2, 'name' => 'users:edit:any']);
        ACPermission::create(['resource_id' => 2, 'name' => 'users:delete:any']);
        ACPermission::create(['resource_id' => 2, 'name' => 'users:restore:any']);
        ACPermission::create(['resource_id' => 2, 'name' => 'users:force-delete:any']);

        ACPermission::create(['resource_id' => 3, 'name' => 'trainings:list:any']);
        ACPermission::create(['resource_id' => 3, 'name' => 'trainings:list:own']);
        ACPermission::create(['resource_id' => 3, 'name' => 'trainings:create']);
        ACPermission::create(['resource_id' => 3, 'name' => 'trainings:edit:any']);
        ACPermission::create(['resource_id' => 3, 'name' => 'trainings:edit:own']);
        ACPermission::create(['resource_id' => 3, 'name' => 'trainings:delete:any']);
        ACPermission::create(['resource_id' => 3, 'name' => 'trainings:delete:own']);

        // create roles and assign existing permissions
        $role0 = ACRole::create(['name' => 'almighty', 'is_system_role' => true]);

        $hrRole = ACRole::create(['name' => 'HR', 'is_system_role' => false]);
        $hrRole -> givePermissionTo('rbac:hr-representative');

        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // $user = \App\Models\User::factory()->create([
        //     'username' => 'user',
        //     'first_name' => 'User',
        //     'last_name' => 'Example',
        //     'email' => 'tester@example.com',
        // ]);

        // $user = \App\Models\User::factory()->create([
        //     'username' => 'admin1',
        //     'first_name' => 'Admin User',
        //     'last_name' => 'Example',
        //     'email' => 'admin1@example.com',
        // ]);
        // $user->assignRole($role0);

        // $user = \App\Models\User::factory()->create([
        //     'username' => 'superadmin',
        //     'first_name' => 'Super-Admin User',
        //     'last_name' => 'Example',
        //     'email' => 'superadmin@example.com',
        // ]);
        // $user->assignRole($role0);
    }

    public function seedMyOwnRolesAndPermissions()
    {
                // -- Base permissions structure
                $permissionGroups = [
                    'posts' => [
                        'posts:create' => 'Tworzenie Postów',
                        'posts:read:any' => 'Przeglądanie Dowolnych Postów',
                        'posts:read:own' => 'Przeglądanie Własnych Postów',
                        'posts:update:any' => 'Edycja Dowolnych Postów',
                        'posts:update:own' => 'Edycja Własnych Postów',
                        'posts:delete:any' => 'Usuwanie Dowolnych Postów',
                        'posts:delete:own' => 'Usuwanie Własnych Postów',
                    ],
                    'users' => [
                        'users:create' => 'Tworzenie',
                        'users:read' => 'Przeglądanie',
                        'users:update' => 'Edycja',
                        'users:delete' => 'Usuwanie',
                    ],
                    'roles' => [
                        'roles:create' => 'Tworzenie',
                        'roles:read' => 'Przeglądanie',
                        'roles:update' => 'Edycja',
                        'roles:delete' => 'Usuwanie',
                    ],
                    'permissions' => [
                        'permissions:read' => 'Przeglądanie',
                    ],
                    'contexts' => [
                        'contexts:create' => 'Tworzenie',
                        'contexts:read' => 'Przeglądanie',
                        'contexts:update' => 'Edycja',
                        'contexts:delete' => 'Usuwanie',
                    ],
                ];

                // Generate permissions
                $permissions = [];
                foreach ($permissionGroups as $resource => $actions) {
                    foreach ($actions as $action => $displayPrefix) {
                        // For posts, create both 'any' and 'own' scopes
                        $scopes = ($resource === 'posts' && in_array($action, ['read', 'update', 'delete']))
                            ? ['any', 'own']
                            : ['any'];

                        foreach ($scopes as $scope) {
                            $scopeDisplay = $scope === 'any' ? 'wszystkich' : 'własnych';
                            $permissions[] = [
                                'name' => "{$resource}:{$action}:{$scope}",
                                'display_name' => "{$displayPrefix} {$scopeDisplay} {$resource}",
                                'resource' => $resource,
                                'action' => $action,
                                'scope' => $scope,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                }

                // Insert all permissions at once for better performance
                // Permission::insert($permissions);

                // Create system roles
                $roles = [
                    [
                        'name' => 'super-admin',
                        'display_name' => 'Super Administrator',
                        'description' => 'Pełny dostęp do systemu',
                        'context' => 'global',
                        'is_system_role' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'admin',
                        'display_name' => 'Administrator',
                        'description' => 'Administracja systemem',
                        'context' => 'global',
                        'is_system_role' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'editor',
                        'display_name' => 'Redaktor',
                        'description' => 'Zarządzanie treścią',
                        'context' => 'global',
                        'is_system_role' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'author',
                        'display_name' => 'Autor',
                        'description' => 'Tworzenie i zarządzanie własną treścią',
                        'context' => 'global',
                        'is_system_role' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ];

                // Role::insert($roles);

                // Assign permissions to roles
                // $superAdmin = Role::where('name', 'super-admin')->first();
                // $admin = Role::where('name', 'admin')->first();
                // $editor = Role::where('name', 'editor')->first();
                // $author = Role::where('name', 'author')->first();

                // // Super Admin gets all permissions
                // $superAdmin->permissions()->attach(Permission::pluck('id'));

                // // Admin gets all permissions except user management
                // $adminPermissions = Permission::where('resource', '!=', 'users')
                //     ->orWhere('action', '!=', 'delete')
                //     ->pluck('id');
                // $admin->permissions()->attach($adminPermissions);

                // // Editor permissions
                // $editorPermissions = Permission::whereIn('resource', ['posts'])
                //     ->whereIn('action', ['create', 'read', 'update'])
                //     ->pluck('id');
                // $editor->permissions()->attach($editorPermissions);

                // // Author permissions
                // $authorPermissions = Permission::whereIn('resource', ['posts'])
                //     ->whereIn('action', ['create', 'read'])
                //     ->where('scope', 'own')
                //     ->pluck('id');
                // $author->permissions()->attach($authorPermissions);

                // // Assign super-admin role to first user (usually created by UsersSeeder)
                // if ($user = User::first()) {
                //     $user->roles()->attach($superAdmin->id, ['context_id' => null]);
                // }

    }
}
