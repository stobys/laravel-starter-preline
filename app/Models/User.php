<?php

namespace App\Models;

use \Spatie\Permission\Traits\HasRoles;
use App\Models\TrainingAttachment;
use App\Traits\Impersonatable;
use App\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Lab404\Impersonate\Models\Impersonate;

#[Fillable([
	'department_id', 'manager_id', 'username', 'password', 'email', 'first_name', 'last_name', 'password_changed_at',
	'personal_id', 'hired_at', 'dismissed_at', 'teta_guid', 'teta_prac_id', 'teta_grupa', 'mpk_code',
	'is_domain_user'
])]



#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Impersonate, Impersonatable, Notifiable, HasRoles, SoftDeletes, SortableTrait;
    // HasRolesAndPermissions;

    protected $sortables = ['id', 'username', 'email', 'first_name', 'last_name', 'full_name','created_at'];

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

            // 'notification_preferences'  => 'array',
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

    public function manager()
    {
		return $this->department->manager;
        // return $this->belongsTo(User::class, 'manager_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function managedDepartments()
    {
        return $this->hasMany(Department::class, 'manager_id');
        // $managers = User::whereHas('managedDepartments')->get(); // zwraca wszystkich menadżerów
    }

    public function isDepartmentManager(): bool
    {
		return $this->managedDepartments()->exists();
    }

    public function subordinates()
    {
        // relacja wygodna do eager loadingu; zwraca users z działu zarządzanego przez tego usera
        return $this->hasManyThrough(
            User::class,            // końcowy model
            Department::class,      // model pośredni
            'manager_id',           // FK na Department wskazujący na user.id
            'department_id',        // FK na User wskazujący na department.id
            'id',                   // lokalny klucz usera
            'id'                    // lokalny klucz departamentu
        )
        -> where('users.id', '!=', $this->id)  // opcjonalnie wyklucz samego managera
        ;
    }

	public function trainings() {
		return $this->belongsToMany(Training::class, 'participant_training', 'participant_id', 'training_id');
	}


    public function isHRRepresentative(): bool
    {
		return $this?->department?->teta_mpk_code == '06-8342';
        return $this->can('rbac:hr-representative');
    }

    public function managesDepartment(Department $department): bool
    {
        return $department->manager_id === $this->id;
    }

    /**
     * Get the profile associated with the user.
     */
    // public function profile()
    // {
    //     return $this->hasOne(UserProfile::class);
    // }
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

    public function isAlmighty()
    {
        return $this->hasRole('almighty');
    }

	public function isBuiltIn()
	{
		return $this->is_built_in;
	}

    public function scopeBuiltInOnly(Builder $query): void
    {
        $query->where('users.is_built_in', true);
    }

    public function scopeWithoutBuiltIn(Builder $query): void
    {
        $query->where('users.is_built_in', false);
    }

	public function uploadedTrainingAttachments()
	{
		return $this->hasMany(TrainingAttachment::class, 'uploaded_by');
	}

	/**
	* By default, all users can impersonate anyone
	* this example limits it so only admins can
	* impersonate other users
	*
	* Czy ten user MOŻE impersonować kogoś?
	* $this = zalogowany user który chce się podszyć
	* $impersonated = user, pod którego chce się podszyć
	*/
	public function canImpersonate(): bool
	{
		// -- almighty user can always impersonate
		if( $this->isAlmighty() ) return true;

		return true; // -- in general users can impersontate other users
	}

	/**
	* By default, all users can be impersonated,
	* this limits it to only certain users.
	*
	* Czy ten user MOŻE BYĆ impersonowany?
	* $this = user pod którego ktoś chce się podszyć
	* $impersonator = user który próbuje się podszyć
	*/
	public function canBeImpersonated(): bool
	{
		// -- cannot impersonate almighty user
		return ! $this->isAlmighty();
	}

	public function canSubstitute(int $user_id): bool
	{
		if( $this->isAlmighty() ) return true;

		// -- can substitute if there is an active Delegation
		return UserDelegation::valid()
				-> where('principal_id', $user_id)
				-> where('substitute_id', $this->id)
				-> exists();
	}

	public function canBeSubstituted(int $user_id): bool
	{
		// -- can be substituted if there is an active Delegation
		return UserDelegation::valid()
			-> where('principal_id', $this->id)
			-> where('substitute_id', $user_id)
			-> exists();
	}

}
