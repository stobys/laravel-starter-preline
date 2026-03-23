<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenericModel extends Model
{
    public static function getTableName()
    {
        return (new static)->getTable();
    }
}
