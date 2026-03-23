<?php

namespace App\Traits;

use App\Models\RBAC\Role;
use App\Models\RBAC\ObjectOwnership;
use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withPivot(['context_id', 'granted_by', 'expires_at'])
            ->withTimestamps();
    }

    /**
     * Get all permissions for the user.
     */
    public function permissions()
    {
        return $this->roles->flatMap(function ($role) {
            return $role->permissions;
        })->unique('id');
    }

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission(string $permissionName, ?string $context = null): bool
    {
        $cacheKey = "user_permissions_{$this->id}" . ($context ? "_$context" : '');

        return Cache::remember($cacheKey, now()->addHour(), function () use ($permissionName, $context) {
            $query = $this->roles()
                ->whereHas('permissions', function ($q) use ($permissionName) {
                    $q->where('name', $permissionName);
                });

            if ($context) {
                $query->where('context', $context);
            }

            return $query->exists();
        });
    }

    /**
     * Check if user has any of the given permissions.
     */
    public function hasAnyPermission(array $permissions, ?string $context = null): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission, $context)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has all of the given permissions.
     */
    public function hasAllPermissions(array $permissions, ?string $context = null): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission, $context)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($roleName, ?string $context = null): bool
    {
        $query = $this->roles();

        if (is_array($roleName)) {
            $query->whereIn('name', $roleName);
        } else {
            $query->where('name', $roleName);
        }

        if ($context) {
            $query->where('context', $context);
        }

        return $query->exists();
    }

    /**
     * Get all owned objects of a specific type.
     */
    public function ownedObjects(string $modelType)
    {
        return $this->hasMany(ObjectOwnership::class)
            ->where('object_type', $modelType)
            ->with('object')
            ->get()
            ->pluck('object');
    }
}
