<?php

namespace App\Services\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use App\Models\Department;

class DepartmentFiltersService
{
    public function apply(): Builder
    {
        $query = Department::query();

        // -- Pobierz filtry z sesji lub request
        $filters = session()->get('filters.departments', []);

        // -- jezeli tylko nieaktywne
        $showActive = in_array('1', Arr::get($filters, 'status', []));
        $showInactive = in_array('0', Arr::get($filters, 'status', []));

        // // -- jezeli tylko nieaktywne
        $query->when(!$showActive && $showInactive, fn($q, $status) =>
            $q->onlyTrashed()
        );

        // // -- jezeli oba
        $query->when(($showActive && $showInactive) || (!$showActive && !$showInactive), fn($q, $status) =>
            $q->withTrashed()
        );

        // -- wyszukiwanie po frazie
        $query->when($filters['search'] ?? null, fn($q, $search) =>
            $q->whereLike('name', '%'. $search .'%')
            	->orWhereLike('teta_name', '%'. $search .'%')
                ->orWhereLike('teta_mpk_code', '%'. $search .'%')
        );

        return $query;
    }

    public function save(array $filters): void
    {
        $filters = $filters['filters'];

        $submit = Arr::get($filters, 'submit', 'clear');
        unset($filters['submit']);

        match($submit) {
            'filter' => session()->put('filters.departments', $filters),
            default => session()->forget('filters.departments'),
        };
    }
}



