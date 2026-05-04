<?php

namespace App\Models\TETA;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\ReadOnlyModelTrait;
use Illuminate\Support\Str;

use App\Models\GenericModel as Model;
use App\Models\Department;

class TetaMPK extends Model
{
    use ReadOnlyModelTrait;

    // -- The database connection used by the model
    protected $connection = 'oracle';

    // -- The database table used by the model
    protected $table = 'rk_mpk';

    public function scopeCompanySwiebodzin(Builder $query): void
    {
        $query->whereNull('firm_id')->where('kod', 'LIKE', '06%');
    }

    public function scopeCompanySkarbimierz(Builder $query): void
    {
        $query->whereNull('firm_id')->where('kod', 'LIKE', '26%');
    }

    public function sync()
    {
		// RK_MPK : id, kod, nazwa, guid
		$model = [
            'name' => Str::title($this -> nazwa) ?? Str::random(8),
			'teta_mpk_id' => $this -> id ?? null,
			'teta_mpk_code' => $this -> kod ?? null,
			'teta_name' => $this -> nazwa ?? null,
			'teta_guid' => $this -> guid ?? null,
        ];

		$department = Department::where('teta_mpk_code', $model['teta_mpk_code'])->first();

		if( $department )
		{
			if($department->name) {
				unset($model['name']);
			}

			$department->update($model);
		}
		else {
			Department::updateOrCreate([
				'teta_mpk_code' => $model['teta_mpk_code'],
			], $model);
		}
    }

}
