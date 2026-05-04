<?php

namespace App\Services\Filters;

use App\Models\Budget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BudgetFiltersService
{
    public function apply(): Builder
    {
        $query = Budget::query()->selectRaw('
			budgets.id,
			budgets.fiscal_year,
			budgets.q1_budget,
			budgets.q2_budget,
			budgets.q3_budget,
			budgets.q4_budget,
			budgets.annual_budget,
			SUM(CASE WHEN t.fiscal_quarter = 1 THEN t.planned_cost ELSE 0 END) as q1_planned_cost,
			SUM(CASE WHEN t.fiscal_quarter = 2 THEN t.planned_cost ELSE 0 END) as q2_planned_cost,
			SUM(CASE WHEN t.fiscal_quarter = 3 THEN t.planned_cost ELSE 0 END) as q3_planned_cost,
			SUM(CASE WHEN t.fiscal_quarter = 4 THEN t.planned_cost ELSE 0 END) as q4_planned_cost,
			SUM(t.planned_cost) as annual_planned_cost
		')
		->leftJoin('trainings as t', function($join) {
			$join->on('t.fiscal_year', '=', 'budgets.fiscal_year')->whereNull('t.deleted_at');
		})
		->groupBy(
			'budgets.id',
			'budgets.fiscal_year',
			'budgets.q1_budget',
			'budgets.q2_budget',
			'budgets.q3_budget',
			'budgets.q4_budget',
			'budgets.annual_budget'
		);

        // // -- Pobierz filtry z sesji lub request
        // $filters = session()->get('filters.budgets', []);

        // // -- wyszukiwanie po frazie
        // $query->when($filters['search'] ?? null, fn($q, $search) =>
        //     $q->whereLike('fiscal_year', '%'. $search .'%')
        //         // ->orWhereLike('full_name', '%'. $search .'%')
        // );

        return $query;
    }

    public function save(array $filters): void
    {
        $filters = $filters['filters'];

        $submit = Arr::get($filters, 'submit', 'clear');
        unset($filters['submit']);

        match($submit) {
            'filter' => session()->put('filters.budgets', $filters),
            default => session()->forget('filters.budgets'),
        };
    }
}



