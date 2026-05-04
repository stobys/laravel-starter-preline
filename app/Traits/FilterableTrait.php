<?php

namespace App\Traits;

use App\Exceptions\FilterableException;

trait FilterableTrait
{

    // -- list of fields considered filterable : MUST BE DEFINED IN MODEL AS KEY/PAIR VALUES of field_name and filter method
    // protected $filterable_fields = [
    //     'id'			=> 'is',
    //     'name'			=> 'like',

    //     'created_at'	=> 'between',
    //     'updated_at'	=> 'between',
    // ];

    public function scopeFilter($query)
    {
        if (! property_exists($this, 'filterable_fields')) {
            throw new FilterableException('Class '. __CLASS__ .' missing required property `filterable_fields`.');
        }

        $model = strtolower(basename(__CLASS__));

        // -- fetch data
        if (request()->isMethod('POST')) {
            collect($this -> filterable_fields) -> map(function ($operator, $name) use ($query, $model) {
                // -- check "field"
                if (request()->has($name) && !empty(request()->get($name))) {
                    if (is_array(request()->get($name))) {
                        foreach (request()->get($name) as $key => $value) {
                            session() -> put('filters.'. $model .'.'. $name .'.'. $key, trim($value));
                        }
                    } else {
                        session() -> put('filters.'. $model .'.'. $name, trim(request()->get($name)));
                    }
                } else {
                    session() -> forget('filters.'. $model .'.'. $name);
                }
            });
        }

        // -- collection filtering
        $this -> modelFiltered($model, false);
        collect($this -> filterable_fields) -> map(function ($operator, $name) use ($query, $model) {
            $scopeName = studly_case($name);

            if (session()->has('filters.'. $model .'.'. $name)) {
                if (method_exists($this, 'scope' . $scopeName)) {
                    $this -> $scopeName(request()->input($name));

                    $this -> modelFiltered($model);
                } else {
                    // -- collection filtering

                    switch ($operator) {
                        case 'is':
                            if (is_array(session('filters.'. $model .'.'. $name))) {
                                $query -> whereIn($name, session('filters.'. $model .'.'. $name));
                            } else {
                                $query -> where($name, session('filters.'. $model .'.'. $name));
                            }

                            $this -> modelFiltered($model);
                        break;

                        case 'like':
                            $query -> where($name, 'LIKE', '%'. session('filters.'. $model .'.'. $name) .'%');

                            $this -> modelFiltered($model);
                        break;

                        case 'between':
                            $min = session()->get('filters.'. $model .'.'. $name .'.min');
                            $max = session()->get('filters.'. $model .'.'. $name .'.max');

                            if (!empty($min) && !empty($max)) {
                                $query -> where($name, '>=', session()->get('filters.'. $model .'.'. $name .'.min'))
                                        -> where($name, '<=', session()->get('filters.'. $model .'.'. $name .'.max'));

                                $this -> modelFiltered($model);
                            } elseif (!empty($min)) {
                                $query -> where($name, '>=', session()->get('filters.'. $model .'.'. $name .'.min'));

                                $this -> modelFiltered($model);
                            } elseif (!empty($max)) {
                                $query -> where($name, '<=', session()->get('filters.'. $model .'.'. $name .'.max'));

                                $this -> modelFiltered($model);
                            }
                        break;
                    }
                }
            }
        });

        return $query;
    }

    protected function modelFiltered($model, $filtered = true)
    {
        if (empty($filtered)) {
            session() -> forget('filters.'. $model .'Filtered');
        } else {
            session() -> put('filters.'. $model .'Filtered', $filtered);
        }
    }
}

