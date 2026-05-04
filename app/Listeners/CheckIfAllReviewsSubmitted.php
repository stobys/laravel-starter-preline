<?php

namespace App\Listeners;

use App\Events\TrainingReviewSubmitted;
use App\Models\Training;
use App\Services\TrainingService;
use App\States\Trainings\Reviewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Attributes\ListensTo;
use Illuminate\Support\Facades\DB;

#[ListensTo(TrainingReviewSubmitted::class)]
class CheckIfAllReviewsSubmitted
{
	// -- Create the event listener.
    public function __construct(public TrainingService $service) {}

    public function handle(TrainingReviewSubmitted $event): void
    {
        $training = $event->review->training;

        $allSubmitted = $training->unsubmittedReviews()->doesntExist();

		if ($allSubmitted) {
			DB::transaction(function () use ($training, $allSubmitted) {
				$training = Training::lockForUpdate()->find($training->id);
				$training->state->transitionTo(Reviewed::class);

				$this->service->createEvaluations($training);
			});
		}
    }
}


