<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SortableTrait;
use App\Traits\Filterable;

class Department extends GenericModel
{
    use Filterable, SortableTrait, SoftDeletes;


    protected $fillable = ['manager_id', 'name', 'abbr', 'teta_mpk_id', 'teta_mpk_code', 'teta_name', 'teta_guid'];
    protected $sortables = ['id', 'name', 'abbr', 'teta_mpk_code', 'created_at'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [

        ];
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function trainings()
    {
        return $this->hasManyThrough(Training::class, User::class, 'department_id', 'user_id');
    }
}
