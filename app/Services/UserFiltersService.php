<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\User;

class UserFiltersService
{
    public function apply(): Builder
    {
        $query = User::query();

        // -- Pobierz filtry z sesji lub request
        $filters = session()->get('filters.users', []);

        $query->when($filters['status'] ?? null, fn($q, $status) =>
            $q->where('status', $status)
        );

        $query->when($filters['search'] ?? null, fn($q, $search) =>
            $q->where('role', $search)
        );

        return $query;
    }

    public function save(array $filter): void
    {

        match($filter['submit']) {
            'filter' => request()->session()->put('filters.users', $filter),
            'clear' => request()->session()->forget('filters.users'),
        };
    }
}
