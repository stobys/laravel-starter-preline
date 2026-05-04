<?php

namespace App\Models\RBAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
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
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Get the permission name in the format 'resource.action'.
     */
    public function getPermissionName(): string
    {
        return "{$this->resource}.{$this->action}";
    }
}
