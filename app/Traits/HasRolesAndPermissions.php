<?php

namespace App\Traits;

use App\Models\RBAC\Role;
use App\Models\RBAC\Permission;
use Illuminate\Support\Facades\Cache;

/**
 * This trait provides role and permission management functionality
 * to any model that needs to have roles and permissions.
 */
trait HasRolesAndPermissions
{
    /**
     * Check if the model has the given role.
     */
    public function hasRole($role, ?string $context = null): bool
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        if (is_array($role)) {
            return $this->roles->whereIn('name', $role)->isNotEmpty();
        }

        if ($role instanceof \Illuminate\Support\Collection) {
            return $role->intersect($this->roles)->isNotEmpty();
        }

        return (bool) $role->intersect($this->roles)->count();
    }

    /**
     * Assign the given role to the model.
     */
    public function assignRole($role, ?int $contextId = null, ?int $grantedById = null, $expiresAt = null)
    {
        $role = $this->getStoredRole($role);
        
        $this->roles()->attach($role, [
            'context_id' => $contextId,
            'granted_by' => $grantedById,
            'expires_at' => $expiresAt
        ]);

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Remove the given role from the model.
     */
    public function removeRole($role)
    {
        $this->roles()->detach($this->getStoredRole($role));
        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Sync the given roles.
     */
    public function syncRoles($roles, ?array $pivotAttributes = [])
    {
        $this->roles()->detach();
        
        foreach ($roles as $role) {
            $this->assignRole($role, 
                $pivotAttributes['context_id'] ?? null,
                $pivotAttributes['granted_by'] ?? null,
                $pivotAttributes['expires_at'] ?? null
            );
        }

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Check if the model has any of the given permissions.
     */
    public function hasAnyPermission(...$permissions): bool
    {
        $permissions = collect($permissions)->flatten();

        return $permissions->contains(function ($permission) {
            return $this->hasPermission($permission);
        });
    }

    /**
     * Check if the model has all of the given permissions.
     */
    public function hasAllPermissions(...$permissions): bool
    {
        $permissions = collect($permissions)->flatten();

        return $permissions->every(function ($permission) {
            return $this->hasPermission($permission);
        });
    }

    /**
     * Give permission to the model.
     */
    public function givePermissionTo(...$permissions)
    {
        $permissions = collect($permissions)
            ->flatten()
            ->map(function ($permission) {
                return $this->getStoredPermission($permission);
            });

        $this->permissions()->syncWithoutDetaching($permissions);
        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Revoke the given permission.
     */
    public function revokePermissionTo($permission)
    {
        $this->permissions()->detach($this->getStoredPermission($permission));
        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Get the cached permissions for the model.
     */
    protected function getCachedPermissions()
    {
        return Cache::remember(
            $this->getPermissionCacheKey(),
            now()->addHour(),
            function () {
                return $this->getAllPermissions();
            }
        );
    }

    /**
     * Get all permissions for the model.
     */
    public function getAllPermissions()
    {
        return $this->roles->flatMap(function ($role) {
            return $role->permissions;
        })->merge($this->permissions)->unique('id');
    }

    /**
     * Get the cache key for the model's permissions.
     */
    protected function getPermissionCacheKey(): string
    {
        return 'permissions_for_user_' . $this->id;
    }

    /**
     * Forget the cached permissions.
     */
    public function forgetCachedPermissions()
    {
        Cache::forget($this->getPermissionCacheKey());
    }

    /**
     * Get the stored role.
     */
    protected function getStoredRole($role)
    {
        if (is_string($role)) {
            return app(Role::class)->where('name', $role)->firstOrFail();
        }

        if (is_int($role)) {
            return app(Role::class)->findOrFail($role);
        }

        return $role;
    }

    /**
     * Get the stored permission.
     */
    protected function getStoredPermission($permission)
    {
        if (is_string($permission)) {
            return app(Permission::class)->where('name', $permission)->firstOrFail();
        }

        if (is_int($permission)) {
            return app(Permission::class)->findOrFail($permission);
        }

        return $permission;
    }

    /**
     * Check if the model has a specific permission.
     */
    public function hasPermissionTo($permission, ?string $context = null): bool
    {
        $permission = $this->getStoredPermission($permission);
        
        return $this->hasDirectPermission($permission) || 
               $this->hasPermissionThroughRole($permission, $context);
    }

    /**
     * Check if the model has the permission directly.
     */
    protected function hasDirectPermission($permission): bool
    {
        $permission = $this->getStoredPermission($permission);
        
        return $this->permissions->contains('id', $permission->id);
    }

    /**
     * Check if the model has the permission through a role.
     */
    protected function hasPermissionThroughRole($permission, ?string $context = null): bool
    {
        $permission = $this->getStoredPermission($permission);
        
        foreach ($permission->roles as $role) {
            if ($this->roles->contains('id', $role->id)) {
                if ($context === null || $role->context === $context) {
                    return true;
                }
            }
        }

        return false;
    }
}
