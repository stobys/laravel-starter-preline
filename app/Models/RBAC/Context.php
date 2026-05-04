<?php

namespace App\Models\RBAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Context extends Model
{
    protected $fillable = [
        'name',
        'type',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Get all roles associated with this context.
     */
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'context', 'name');
    }

    /**
     * Get the context's display name.
     */
    public function getDisplayNameAttribute(): string
    {
        return ucfirst($this->name);
    }
}
