<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Notification extends GenericModel
{
    protected $fillable = [
        'user_id', 'message', 'read_at', 'read_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'read_at' => 'date:Y-m-d H:i',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRead(Builder $query): void
    {
        $query->whereNotNull('read_at');
    }

    public function scopeUnread(Builder $query): void
    {
        $query->whereNull('read_at');
    }
}
