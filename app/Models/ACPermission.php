<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;

use App\Traits\SortableTrait;
use App\Models\ACResource;

class ACPermission extends Permission
{
    use SortableTrait;

    protected $sortables = ['id', 'name', 'created_at'];

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
