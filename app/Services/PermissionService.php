<?php

namespace App\Services;

use App\Models\User;
use App\Models\RBAC\Permission;
use Illuminate\Support\Facades\Cache;

class PermissionService
{
    public function checkPermission(User $user, string $permission, $object = null, $contextId = null): bool
    {
        // -- Cache kluczowe sprawdzenia uprawnień
        $cacheKey = "user_permissions_{$user->id}_{$contextId}";

        $userPermissions = Cache::remember($cacheKey, 3600, function () use ($user, $contextId) {
            return $user->getPermissions($contextId);
        });

        // -- Check if permission exists in cached permissions
        if (in_array($permission, $userPermissions)) {
            return true;
        }

        // -- Fallback to direct check if not found in cache
        return $user->hasPermission($permission, $object, $contextId);
    }

    public function createPermission(array $data): Permission
    {
        return Permission::create([
            'name' => $data['resource'] . ':' . $data['action'] . ':' . $data['scope'],
            'display_name' => $data['display_name'],
            'resource' => $data['resource'],
            'action' => $data['action'],
            'scope' => $data['scope'] ?? 'any',
            'description' => $data['description'] ?? null,
        ]);
    }

    public function assignObjectOwnership(User $user, $object): void
    {
        $user->ownedObjects()->create([
            'object_type' => get_class($object),
            'object_id' => $object->id,
        ]);
    }

    public function getUsersWithPermission(string $permission, $contextId = null): Collection
    {
        return User::whereHas('roles.permissions', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->when($contextId, function ($query) use ($contextId) {
            return $query->whereHas('roles', function ($q) use ($contextId) {
                $q->wherePivot('context_id', $contextId);
            });
        })->get();
    }
}
