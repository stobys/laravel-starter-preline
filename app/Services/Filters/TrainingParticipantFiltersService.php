<?php

namespace App\Services\Filters;

use App\Models\Pivots\ParticipantTraining;
use App\Models\TrainingEvaluation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\DB;

class TrainingParticipantFiltersService
{
    public function apply(): Builder
    {
		$query = ParticipantTraining::addSelect([
			'participant_training.*',
			'review_average' => DB::table('training_reviews')
				->select('review_average')
				->whereColumn('training_id', 'participant_training.training_id')
				->whereColumn('reviewer_id', 'participant_training.participant_id')
				->limit(1),
			'reviewer_id' => DB::table('training_reviews')
				->select('reviewer_id')
				->whereColumn('training_id', 'participant_training.training_id')
				->whereColumn('reviewer_id', 'participant_training.participant_id')
				->limit(1),
			'submitted_at' => DB::table('training_reviews')
				->select('submitted_at')
				->whereColumn('training_id', 'participant_training.training_id')
				->whereColumn('reviewer_id', 'participant_training.participant_id')
				->limit(1)
		]);

        // -- Pobierz filtry z sesji lub request
        $filters = session()->get('filters.trainings_pvt_participants', []);

		// -- jezeli wybrane dzialy
        $query->when($filters['department'] ?? null, fn($q, $search) =>
            $q
				-> whereHas('participant', function($has) use ($search) {
					$has->whereIn('department_id', $search);
				})
        );

		// -- jezeli wybrane typy
        $query->when($filters['type'] ?? null, fn($q, $search) =>
            $q
				-> whereHas('training', function($has) use ($search) {
					$has->whereIn('type', $search);
				})
        );

		// -- jezeli wybrane statusy
        $query->when($filters['state'] ?? null, fn($q, $search) =>
            $q
				-> whereHas('training', function($has) use ($search) {
					$has->whereIn('state', $search);
				})
        );

        // -- wyszukiwanie po frazie
        $query->when($filters['search'] ?? null, fn($q, $search) =>
			$q
				-> whereHas('training', function($has) use ($search) {
					$has->where('title', 'like', "%{$search}%");
				})
				-> orWhereHas('participant', function($has) use ($search) {
					$has->where('full_name', 'like', "%{$search}%");
				})
        );

        return $query;
    }

    public function save(array $filters): void
    {
        $filters = $filters['filters'];

        $submit = Arr::get($filters, 'submit', 'clear');
        unset($filters['submit']);

        match($submit) {
            'filter' => session()->put('filters.trainings_pvt_participants', $filters),
            default => session()->forget('filters.trainings_pvt_participants'),
        };
    }
}



