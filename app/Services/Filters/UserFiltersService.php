<?php

namespace App\Services\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserFiltersService
{
    public function apply(): Builder
    {
        $query = User::query()->withoutBuiltIn()->with('roles');

        // -- Pobierz filtry z sesji lub request
        $filters = session()->get('filters.users', []);

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

        // -- wyszukiwanie po dziale
        $query->when($filters['department'] ?? null, fn($q, $search) =>
            $q->whereIn('department_id', $search)
        );

        // -- wyszukiwanie po frazie
        $query->when($filters['search'] ?? null, fn($q, $search) =>
            $q->whereLike('username', '%'. $search .'%')
                ->orWhereLike('full_name', '%'. $search .'%')
        );

        return $query;
    }

    public function save(array $filters): void
    {
        $filters = $filters['filters'];

        $submit = Arr::get($filters, 'submit', 'clear');
        unset($filters['submit']);

        match($submit) {
            'filter' => request()->session()->put('filters.users', $filters),
            default => request()->session()->forget('filters.users'),
        };
    }
}



