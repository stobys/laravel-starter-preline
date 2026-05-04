<?php

namespace App\Services;

use App\Enums\TrainingState;
use App\Enums\TrainingStatus;
use App\Enums\TrainingType;
use App\Events\TrainingEvaluationSubmitted;
use App\Events\TrainingReviewSubmitted;
use App\Models\ScheduledNotification;
use App\Models\Training;
use App\Models\TrainingAttachment;
use App\Models\TrainingEffectivenessEvaluation;
use App\Models\TrainingEvaluation;
use App\Models\TrainingReview;
use App\Models\User;
use App\Notifications\EvaluationReminderNotification;
use App\Notifications\TrainingFullyApprovedNotification;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File as FileRule;

class TrainingService
{
    public function getValidateRulesForImport(): array
    {
        $rules = [
            'importFile' => [
                'required',
                FileRule::types(['csv', 'txt'])->max(1 * 1024) // 1 * 1M
            ], // 1MB max
        ];

        return $rules;
    }

    public function getValidateMessages(): array
    {
        return [
            'importFile.required' => __('trainings.validation.import-file-required'),
            'importFile.mimes' => __('trainings.validation.import-file-mimes'),
            'importFile.max' => __('trainings.validation.import-file-max'),

            // 'first_name.min' => 'Imię musi mieć co najmniej 2 znaki.',
            // 'last_name.required' => 'Nazwisko jest wymagane.',
            // 'last_name.min' => 'Nazwisko musi mieć co najmniej 2 znaki.',
            // 'username.required' => 'Nazwa użytkownika jest wymagana.',
            // 'username.unique' => 'Ta nazwa użytkownika jest już zajęta.',
            // 'username.alpha_dash' => 'Nazwa użytkownika może zawierać tylko litery, cyfry, myślniki i podkreślenia.',
            // 'email.required' => 'Email jest wymagany.',
            // 'email.email' => 'Podaj prawidłowy adres email.',
            // 'email.unique' => 'Ten email jest już zarejestrowany.',
            // 'password.required' => 'Hasło jest wymagane.',
            // 'password.min' => 'Hasło musi mieć co najmniej 8 znaków.',
            // 'password.confirmed' => 'Potwierdzenie hasła nie pasuje.',
        ];
    }

    protected $training_id = null;

    public function setTrainingId(int $training_id) {
        $this->training_id = $training_id;

        return $this;
    }

    public function query($with_filter = false) {
        return Training::query();
    }

    // -- passing validated $data from controller to service
    public function save($data, $submit = 'draft')
    {
        // -- using action classes in such small project would be an overkill IMHO ..
        // TrainingStoreAction::run($data);
        // $qs = (new SaveBooking)($this->data);

        // .. hence ..
        if ( $submit == 'submit' ) {
            $data += ['submitted_at' => now(), 'submitted_by' => auth()->id()];
        }

        $training = Training::create($data);

        // $training->logStateTransition($data['state']);

        return [
            'errno' => $training->exists ? 0 : 1,
            'errmsg' => $training->exists ? 'Training saved successfully' : 'Training not saved',
            'model' => $training
        ];
    }

    // -- passing validated $data from controller to service
    public function update($model, $data)
    {
        if(!$model->exists) {
            $model = $this->save($data);
        }
        else {
            $model->update($data);
        }

        return [
            'errno' => $model->exists ? 0 : 1,
            'errmsg' => $model->exists ? 'Training saved successfully' : 'Training not saved',
            'model' => $model
        ];
    }

    public function submitReview($training, $data)
    {
        $model = [
            // 'training_id' => $training->id,
            'submitted_at' => Carbon::now(),
            'review_comment' => Arr::get($data, 'review_comment', ''),
            'review_of_meeting_expectations' => Arr::get($data, 'review.review_of_meeting_expectations'),
            'review_of_application_of_acquired_information_at_work' => Arr::get($data, 'review.review_of_application_of_acquired_information_at_work'),
            'review_of_the_use_of_training_time' => Arr::get($data, 'review.review_of_the_use_of_training_time'),
            'review_of_recommendations_for_other_employees' => Arr::get($data, 'review.review_of_recommendations_for_other_employees'),
            'review_of_instructor_prepatation_to_conduct' => Arr::get($data, 'review.review_of_instructor_prepatation_to_conduct'),
            'review_of_local_and_technical_conditions' => Arr::get($data, 'review.review_of_local_and_technical_conditions'),
            'review_of_overall_preparation' => Arr::get($data, 'review.review_of_overall_preparation'),
            'review_of_training_materials_and_their_use_at_work' => Arr::get($data, 'review.review_of_training_materials_and_their_use_at_work'),
        ];

        $model['review_average'] = (
            $model['review_of_meeting_expectations']
            + $model['review_of_application_of_acquired_information_at_work']
            + $model['review_of_the_use_of_training_time']
            + $model['review_of_recommendations_for_other_employees']
            + $model['review_of_instructor_prepatation_to_conduct']
            + $model['review_of_local_and_technical_conditions']
            + $model['review_of_overall_preparation']
            + $model['review_of_training_materials_and_their_use_at_work']
        ) / 8;

		$review = TrainingReview::updateOrCreate([
			'training_id' => $training->id,
			'reviewer_id' => auth()->id(),
		], $model);

		if ( $review->wasChanged('submitted_at') )
		{
			TrainingReviewSubmitted::dispatch($review);
		}

        return $review;
    }

    public function submitEvaluation($training, $participant, $data)
    {
        $model = [
            // 'training_id' => $training->id,
            // 'participant_id' => $participant->id,

            'evaluation_of_use_of_knowledge' => (int)Arr::get($data, 'evaluation_of_use_of_knowledge'),
            'evaluation_of_use_of_knowledge_comment' => Arr::get($data, 'evaluation_of_use_of_knowledge_comment'),
            'evaluation_of_need_for_further_training' => (int)Arr::get($data, 'evaluation_of_need_for_further_training'),
            'evaluation_of_need_for_further_training_comment' => Arr::get($data, 'evaluation_of_need_for_further_training_comment', null),
			'evaluation_comment'	=> Arr::get($data, 'evaluation_comment', null),

			'submitted_at'	=> Carbon::now(),
			'submitted_by'	=> auth()->id(),
        ];

        $evaluation = TrainingEvaluation::updateOrCreate([
			'training_id' => $training->id,
			'participant_id' => $participant->id,
		], $model);

        if( $evaluation->wasChanged('submitted_at') ) {
			TrainingEvaluationSubmitted::dispatch($evaluation);
        }

        return $evaluation;
    }

    public function getTypes(): Collection|Array
    {
        return TrainingType::getOptions();
    }

    public function getStates(): Collection|Array
    {
        return TrainingState::getOptions();
    }

    public function getStatuses(): Collection|Array
    {
        return TrainingStatus::getOptions();
    }

    public function getYears(): Collection|Array
    {
        $startYear = (int)date('Y')-1;
        $endYear = (int)date('Y')+2;

        return collect(range($startYear, $endYear)); // ->mapWithKeys(fn($year) => [$year => $year]);
    }

    public function getCurrentFY(): int
    {
        $year = (int)date('Y');
        $month = (int)date('m');

        return $year + (($month >= 10) ? 1 : 0);
    }

    public function getCurrentFQ(): int
    {
        $month = (int)date('m');

        return match ($month) {
            10, 11, 12 => 1,
            1, 2, 3 => 2,
            4, 5, 6 => 3,
            7, 8, 9 => 4,
            default => 1,
        };
    }

    public function isFICOApprovalRequired($training)
    {
        return $training -> cost > 5000;
    }

    public function isPMApprovalRequired($training)
    {
        return $training -> cost > 10000;
    }

    public function getExportFileName()
    {
        $baseName = Str::studly(Training::getTableName());
        return sprintf('%s-%s.csv', $baseName, now()->format('YmdHis'));
    }

    public function setStatus($training, $status)
    {
        // -- TODO : any logic here needed?
        $training->status = $status;
        $training->save();
    }

    public function saveAttachments($attachments, $disk = 'attachments')
    {
        // -- zapis do storage/app/attachments
        $stored = [];

        $stored = collect($attachments)->mapWithKeys(function ($file) use ($disk) {
            $filename = Str::orderedUuid()->toString();

            $storedFile = $file->storeAs(path: date('Y'), name: $filename, options: ['disk' => $disk]);

            return [
                $filename => [
                    'uuid' => $filename,
                    'storage_disk' => $disk,
                    'storage_path' => $storedFile,
                    'tmp_path' => $file->getRealPath(),
                    'filename' => $file->getClientOriginalName(), // -- original fileename
                    'mime_type' => $file->getMimeType(), // -- original mime type
                    'size_bytes' => $file->getSize(), // -- original file size
                    'hash_sha256' => hash_file('sha256', $file->getRealPath()), // -- original file hash
                    'hash_name' => $file->hashName(),
                ]
            ];
        });

        // -- create attachemnt models and delete temp files
        $attachments = $stored->map(function ($file) {
            // -- jezeli zaspisano plik, i nadal istnieje w temp, usuń
            if (File::exists($file['tmp_path'])) {
                File::delete($file['tmp_path']);     // bool
            }

            return TrainingAttachment::create([
                'training_id' => $this->training_id,
                'uploaded_by' => auth()->id(),
                'uuid' => $file['uuid'],
                'filename' => $file['filename'],
                'storage_disk' => $file['storage_disk'],
                'storage_path' => $file['storage_path'],
                'mime_type' => $file['mime_type'] ?? null,
                'size_bytes' => $file['size_bytes'] ?? null,
                'hash_sha256' => $file['hash_sha256'] ?? null,
                'hash_name' => $file['hash_name'] ?? null,
            ]);
        });

        return $attachments;
    }

    /**
     * Natychmiastowa wysyłka powiadomienia (bezpośrednio do kolejki)
     * Użyj dla prostych powiadomień bez warunków biznesowych
     */
    public function immediateNotifyFullyApproved($training)
    {
        $training->user->notify(
            new TrainingFullyApprovedNotification($training->id)
        );
    }

    /**
     * Zaplanowana wysyłka powiadomienia (przez scheduled_notifications)
     * Użyj dla powiadomień z opóźnieniem lub warunkami biznesowymi
     *
     * @param Training $training
     * @param \Carbon\Carbon|string $scheduledAt - kiedy wysłać (np. now()->addDays(7))
     */
    public function scheduledNotifyFullyApproved($training, $scheduledAt = null)
    {
        ScheduledNotification::create([
            'notifiable_type' => User::class,
            'notifiable_id' => $training->user->id,
            'notification_class' => TrainingFullyApprovedNotification::class,
            'notification_data' => [
                'training_id' => $training->id,
            ],
            'scheduled_at' => $scheduledAt ?? now(),
        ]);
    }

    /**
     * Zaplanuj przypomnienie o ewaluacji (za X dni po zakończeniu szkolenia)
     * Przykład użycia scheduled notifications z warunkami biznesowymi
     */
    public function scheduleEvaluationReminder($training, $daysAfterEnd = 7)
    {
        ScheduledNotification::create([
            'notifiable_type' => User::class,
            'notifiable_id' => $training->user->id,
            'notification_class' => EvaluationReminderNotification::class,
            'notification_data' => [
                'training_id' => $training->id,
            ],
            'scheduled_at' => $training->ends_at->addDays($daysAfterEnd),
        ]);
    }

	public function createReviews(Training $training)
	{
		// -- Create evaluations for every approved participant
		$training->participants()->wherePivotNotNull('approved_at')->wherePivotNull('no_show')->each(function ($participant) use ($training) {
			$training->reviews()->create([
				'training_id' => $training->id,
				'reviewer_id' => $participant->id,
			]);
		});
	}

	public function createEvaluations(Training $training)
	{
		// -- Create evaluations for every approved participant
		$training->participants()->wherePivotNotNull('approved_at')->wherePivotNull('no_show')->each(function ($participant) use ($training) {
			$training->evaluations()->create([
				'training_id' => $training->id,
				'participant_id' => $participant->id,
				'available_at' => Carbon::now()->addDays(config('app.post_training_evaluation_period', 180)),
			]);
		});
	}

	public function flashTraining(Training $training)
	{
		$training->evaluations()->delete();
		$training->reviews()->delete();

		$training->participants()->newPivotQuery()->update([
			'approved_at' => null,
			'approved_by' => null,
			'rejected_at' => null,
			'rejected_by' => null,
		]);

		$training->update(['state' => 'planned']);

		return $training;
	}
}
