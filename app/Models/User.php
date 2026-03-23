<?php

namespace App\Models;

use \Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

#[Fillable(['username', 'password', 'email', 'first_name', 'last_name', 'password_changed_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;
    // HasRolesAndPermissions;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password'                  => 'hashed',
            'password_changed_at'       => 'datetime',
            'email_verified_at'         => 'datetime',
            'created_at'                => 'datetime',
        ];
    }

    public static function getTableName()
    {
        return (new static)->getTable();
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($user) {
            if ($user->isDirty('password')) {
                $user->password_changed_at = now();
            }
        });
    }

    protected static function booted()
    {
        // static::created(function ($user) {
        //     $user->profile()->create([
        //         // Domyślne wartości dla UserProfile
        //         // 'bio' => '',
        //         // 'avatar' => null,
        //         // inne pola...
        //     ]);
        // });
    }

    /**
     * Get the profile associated with the user.
     */
    // public function profile()
    // {
    //     return $this->hasOne(UserProfile::class);
    // }

    public function getFullNameAttribute() {
        return $this->last_name . ', ' . $this->first_name;
    }

    public function getPasswordAgeAttribute() {
        $lastChange = $this->password_changed_at ?: $this->created_at;

        return (int) $lastChange->diffInDays(Carbon::now());
    }

    public function getPasswordAgePercentAttribute() {
        $lastChange = $this->password_changed_at ?: $this->created_at;
        $daysSinceLastChange = (int) $lastChange->diffInDays(Carbon::now());
        $expiryAge = (int) config('password-age.expiry-age');

        return min(100, max(0, (int) (($daysSinceLastChange / $expiryAge) * 100)));
    }

    public function hasExpiredPassword()
    {
        $lastChange = $this->password_changed_at ?: $this->created_at;

        return ((int) $lastChange->diffInDays(Carbon::now()) >= (int)config('password-age.expiry-age'));
    }

    public static function findByFullname($full_name): User
    {
        $name = collect(explode(',', $full_name)) -> map(fn($item) => trim($item))->toArray();

        return self::query()
            -> whereRaw('LOWER(last_name) = ?', [strtolower($name[0])])
            -> whereRaw('LOWER(first_name) = ?', [strtolower($name[1])])
            -> firstOrFail();
    }

    // public function isAlmighty()
    // {
    //     return $this->hasRole('almighty');
    // }

    // public function scopeSystemOnly(Builder $query): void
    // {
    //     $query->where('users.is_system', true);
    // }

    // public function scopeNonSystemOnly(Builder $query): void
    // {
    //     $query->where('users.is_system', false);
    // }
}
