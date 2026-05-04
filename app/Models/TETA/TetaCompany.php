<?php

namespace App\Models\TETA;

use App\Models\GenericModel as Model;
use App\Traits\ReadOnlyModelTrait;

class TetaCompany extends Model
{
    use ReadOnlyModelTrait;

    // -- The database connection used by the model
    protected $connection = 'oracle';

    // -- The database table used by the model
    protected $table = 'teta_firmy';

    public function sync()
    {
        $model = [
            // 'id'            => $this -> id,
            // 'code'          => $this -> kod,
            'name'          => $this -> nazwa,
            // 'description'   => $this -> opis,
            // 'guid'          => $this -> guid,
        ];

        // Company::updateOrCreate(['id' => $this -> id, 'code' => $this -> kod], $model);
    }
}
