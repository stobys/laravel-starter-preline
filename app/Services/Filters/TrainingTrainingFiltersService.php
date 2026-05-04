<?php

namespace App\Services\Filters;

use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class TrainingTrainingFiltersService
{
    public function apply(): Builder
    {
        $query = Training::query();

		// filtrujemy
			// -- HR widzi wszystko - brak filtrow

			// -- Manager dzialu - widzi swoje i swoich pracownikow
			$userIsDepartmentManager = auth()->user()->managedDepartments()->exists();

			$query->when($userIsDepartmentManager, function($q) {
				$subordinateIds = User::select('id')->whereIn('department_id', auth()->user()->managedDepartments()->select('id'))->pluck('id');

				$q -> whereHas('participants', function (Builder $q) use ($subordinateIds) {
					$q -> whereIn('participant_id', $subordinateIds)
						-> orWhere('participant_id', auth()->id()); // + własne szkolenia
				});
			});

			// -- Pracownik - widzi tylko swoje
			$query->when(!$userIsDepartmentManager && !auth()->user()->isHRRepresentative(), fn($q) =>
				$q->whereHas('participants', function (Builder $q) {
					$q->where('participant_id', auth()->id());
				})
			);

        // -- Pobierz filtry z sesji lub request
        $filters = session()->get('filters.trainings', []);

		// -- jezeli wybrane typy
        $query->when($filters['type'] ?? null, fn($q, $search) =>
            $q->whereIn('type', $filters['type'])
                // ->orWhereLike('full_name', '%'. $search .'%')
        );

		// -- jezeli wybrane statusy
        $query->when($filters['state'] ?? null, fn($q, $search) =>
            $q->whereIn('state', $filters['state'])
                // ->orWhereLike('full_name', '%'. $search .'%')
        );

		$cost_ge = (int)Arr::get($filters, 'cost_ge', null);
        $query->when($cost_ge, fn($q, $search) =>
            $q->where('planned_cost', '>=', $filters['cost_ge'])
                // ->orWhereLike('full_name', '%'. $search .'%')
        );

		$cost_le = (int)Arr::get($filters, 'cost_le', null);
        $query->when($cost_le, fn($q, $search) =>
            $q->where('planned_cost', '<=', $filters['cost_le'])
                // ->orWhereLike('full_name', '%'. $search .'%')
        );

        // -- Zabudzetowane lub nie
        $showPlanned = in_array('1', Arr::get($filters, 'budget', []));
        $showUnplanned = in_array('0', Arr::get($filters, 'budget', []));

        // -- jezeli tylko niezabudzetowane
        $query->when(!$showPlanned && $showUnplanned, fn($q) =>
            $q->where('budget_included', false)
        );

        // -- jezeli tylko zabudzetowane
        $query->when($showPlanned && !$showUnplanned, fn($q) =>
            $q->where('budget_included', true)
        );

        // -- wyszukiwanie po frazie
        $query->when($filters['search'] ?? null, fn($q, $search) =>
            $q->whereLike('title', '%'. $search .'%')
                // ->orWhereLike('full_name', '%'. $search .'%')
        );

        return $query;
    }

    public function save(array $filters): void
    {
        $filters = $filters['filters'];

        $submit = Arr::get($filters, 'submit', 'clear');
        unset($filters['submit']);

        match($submit) {
            'filter' => session()->put('filters.trainings', $filters),
            default => session()->forget('filters.trainings'),
        };
    }
}



