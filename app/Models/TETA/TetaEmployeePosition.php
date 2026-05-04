<?php

namespace App\Models\TETA;

use App\Models\GenericModel as Model;
use App\Traits\ReadOnlyModelTrait;

class TetaEmployeePosition extends Model
{
    use ReadOnlyModelTrait;

    // -- The database connection used by the model
    protected $connection = 'oracle';

    // -- The database table used by the model
    protected $table = 'sl_stan';

    protected $primaryKey = 'id';

    public function sync()
    {
        // T_PRAC: prac_id, imie, imie_2, nazwisko, nr_ew, data_zatr, data_rozw, plec, guid
        $model = [
            'id'       => $this -> id,
            'name'   => $this -> nazwa,
        ];

        // EmployeePosition::updateOrCreate(['id' => $this -> id], $model);
    }
}
