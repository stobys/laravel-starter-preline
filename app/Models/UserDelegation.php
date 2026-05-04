<?php

namespace App\Models;

use App\Traits\SortableTrait;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

#[Fillable(['principal_id', 'substitute_id', 'valid_from', 'valid_to'])]
class UserDelegation extends Model
{
    use SortableTrait;

    protected $sortables = ['id', 'principal_id', 'substitute_id', 'valid_from', 'valid_to', 'created_at'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'valid_from'	=> 'datetime',
            'valid_to'      => 'datetime',
            'created_at'    => 'datetime',
        ];
    }

    public static function getTableName()
    {
        return (new static)->getTable();
    }

    public function principal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'principal_id');
    }

    public function substitute(): BelongsTo
    {
        return $this->belongsTo(User::class, 'substitute_id');
    }

    public function scopeIncoming(Builder $query): void
    {
        $query->whereSubstituteId(auth()->id());
    }

    public function scopeOutgoing(Builder $query): void
    {
        $query->wherePrincipalId(auth()->id());
    }

    public function scopeValid(Builder $query): void
    {
            $query->where(function (Builder $q) {
        			$q->whereNull('valid_from')->orWhere('valid_from', '<', now());
    			})->where(function (Builder $q) {
        			$q->whereNull('valid_to')->orWhere('valid_to', '>', now());
    		});
    }

	public function isValid()
	{
		return
			(is_null($this->valid_from) || $this->valid_from < now()) // nie ma poczatku (od zawsze), lub jestesmy juz po data staru
			&&
			(is_null($this->valid_to) || $this->valid_to > now()) // nie ma konca (na zawsze) lub jestesmy przed data konca
		;
	}

	public function isPast()
	{
		return $this->valid_to < now();
	}

	public function isFuture()
	{
		return $this->valid_from > now();
	}
}
