<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Builder;

#[WithoutTimestamps]
class NotificationSetting extends GenericModel
{
    protected $fillable = [
        'user_id', 'action', 'email', 'sms', 'in_app'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser(Builder $query, int $user_id): void
    {
        $query->whereUserId($user_id);
    }

	public static function defaults(): array
	{
		return ['email' => false, 'sms' => false, 'in_app' => true];
	}
}
