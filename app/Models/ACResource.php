<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ACResource extends Model
{
    protected $table = 'ac_resources';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * A role may be given various permissions.
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(config('permission.models.permission'), 'resource_id');
    }

    /**
     * Get the permission name in the format 'resource.action'.
     */
    public function getDescriptionAttribute(): string
    {
        return __("rbac:resource:{$this->name}");
        // return "{$this->resource}.{$this->action}";
    }
}
