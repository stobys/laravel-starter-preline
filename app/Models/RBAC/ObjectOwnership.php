<?php

namespace App\Models\RBAC;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\MorphTo;

class ObjectOwnership extends Model
{
    protected $fillable = [
        'user_id',
        'object_type',
        'object_id',
        'assigned_at'
    ];

    protected $dates = [
        'assigned_at',
    ];

    /**
     * Get the owner (user) of the object.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the owned object.
     */
    public function object()
    {
        return $this->morphTo('object', 'object_type', 'object_id');
    }

    /**
     * Check if the object is owned by the given user.
     */
    public static function isOwnedBy($object, $userId): bool
    {
        return static::where([
            'object_type' => get_class($object),
            'object_id' => $object->id,
            'user_id' => $userId
        ])->exists();
    }
}
