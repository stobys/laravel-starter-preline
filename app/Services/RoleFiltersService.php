<?php

namespace App\Services;

use App\Models\ACRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class RoleFiltersService
{
    public function apply(): Builder
    {
        $query = ACRole::query();

        // -- Pobierz filtry z sesji lub request
        $filters = session()->get('filters.roles', []);

        // -- jezeli tylko nieaktywne
        $showActive = in_array('1', Arr::get($filters, 'status', []));
        $showInactive = in_array('0', Arr::get($filters, 'status', []));

        // -- jezeli tylko nieaktywne
        $query->when(!$showActive && $showInactive, fn($q, $status) =>
            $q->onlyTrashed()
        );

        // -- jezeli oba
        $query->when(($showActive && $showInactive) || (!$showActive && !$showInactive), fn($q, $status) =>
            $q->withTrashed()
        );

        // -- wyszukiwanie po frazie
        $query->when($filters['search'] ?? null, fn($q, $search) =>
            $q->whereLike('name', '%'. $search .'%')
        );

        return $query;
    }

    public function save(array $filters): void
    {
        $filters = $filters['filters'];

        $submit = Arr::get($filters, 'submit', 'clear');
        unset($filters['submit']);

        match($submit) {
            'filter' => request()->session()->put('filters.roles', $filters),
            default => request()->session()->forget('filters.roles'),
        };
    }
}
