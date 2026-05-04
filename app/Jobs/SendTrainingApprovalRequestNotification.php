<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\Training;
use App\Models\User;
use App\Mail\TrainingApprovalMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTrainingApprovalRequestNotification implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // -- Create a new job instance.
    public function __construct(
        public Training $training,
        public User $supervisor,
    ) {}

    // -- Execute the job.
    public function handle(): void
    {
        // Sprawdź czy szkolenie nadal czeka na akceptację
        // (mogło zostać zaakceptowane zanim job się wykonał)
        if (!$training->isPendingApproval()) {
            return;
        }

        Mail::to($this->supervisor)->send(
            new TrainingApprovalRequestMail($this->training)
        );
    }
}
