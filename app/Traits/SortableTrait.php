<?php

namespace App\Traits;

use App\Exceptions\SortableException;

trait SortableTrait
{
    // -- list of fields considered sortable : MUST BE DEFINED IN MODEL
    // protected $sortables = ['id', 'name', 'created_at'];

    public function scopeApplySort($query)
    {
        if (! property_exists($this, 'sortables')) {
            throw new SortableException('Class '. __CLASS__ .' missing required property `sortables`.');
        }

        $model = strtolower(basename(__CLASS__));
        $field = request()->input('sf', null);  // default null
        $order = request()->input('so', 'asc');  // 'asc' lub 'desc'

        // -- jezeli zdefiniowano jawnie pole do sortowania
        if( ! is_null($field) ) {
            $field = in_array($field, $this->sortables) ? $field : null;
            match($order) {
                'desc'  => $order = 'desc',
                'asc'   => $order = 'asc',
                default => $order = 'asc',
            };

            session()->put('sort.'. $model .'.field', $field);
            session()->put('sort.'. $model .'.order', $order);
        }

        $sortField = session('sort.'. $model .'.field', null);

        // -- fetch data
        if ( !is_null($sortField) ) {
            $sortOrder = session('sort.'. $model .'.order', 'asc');

            $query->orderBy($sortField, $sortOrder);
        }

        return $query;
    }

}

