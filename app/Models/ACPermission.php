<?php

namespace App\Models;

use App\Models\ACResource;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ACPermission extends Permission
{
    // protected $table = 'DomainRelatedSettings';

    protected $fillable = [
        'name',
        'display_name',
        'resource',
        'action',
        'scope',
        'description'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * The roles that belong to the permission.
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(ACResource::class, 'resource_id');
    }

    /**
     * The roles that belong to the permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.role'),
            config('permission.table_names.role_has_permissions'),
            app(PermissionRegistrar::class)->pivotPermission,
            app(PermissionRegistrar::class)->pivotRole,
        );
    }

    /**
     * Get the permission name in the format 'resource.action'.
     */
    public function getDescriptionAttribute(): string
    {
        return __("permission:{$this->name}");
    }
}
