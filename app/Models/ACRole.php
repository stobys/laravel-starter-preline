<?php

namespace App\Models;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ACRole extends Role
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'guard_name',
        'is_system_role'
    ];

    protected $casts = [
        'is_system_role' => 'boolean',
    ];

    /**
     * The permissions that belong to the role.
     */
    // public function permissions(): BelongsToMany
    // {
    //     return $this->belongsToMany(ACPermission::class);
    // }

    /**
     * The users that belong to the role.
     */
    // public function users(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class)
    //         ->withPivot(['context_id', 'granted_by', 'expires_at'])
    //         ->withTimestamps();
    // }

    /**
     * A role may be given various permissions.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions'),
            app(PermissionRegistrar::class)->pivotRole,
            app(PermissionRegistrar::class)->pivotPermission
        );
    }

    /**
     * A role belongs to some users of the model associated with its guard.
     */
    public function users(): BelongsToMany
    {
        return $this->morphedByMany(
            getModelForGuard($this->attributes['guard_name'] ?? config('auth.defaults.guard')),
            'model',
            config('permission.table_names.model_has_roles'),
            app(PermissionRegistrar::class)->pivotRole,
            config('permission.column_names.model_morph_key')
        );
    }

    /**
     * Check if role has a specific permission.
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }
}
