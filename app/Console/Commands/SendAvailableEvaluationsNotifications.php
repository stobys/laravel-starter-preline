<?php

namespace App\Console\Commands;

use App\Mail\AvailableEvaluationsMail;
use App\Models\TrainingEvaluation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAvailableEvaluationsNotifications extends Command
{
    protected $signature = 'evaluations:notify-available
                            {--dry-run : Wyświetl wynik bez wysyłania maili}';

    protected $description = 'Wysyła powiadomienia o zaległych ocenach do przełożonych (jeden mail per przełożony)';

    public function handle(): int
    {
        $today = now()->startOfDay();

        // Pobierz zaległe oceny (data <= dziś, status != completed)
        // Grupuj od razu po przełożonym, żeby wysłać jeden mail na supervisora
        $grouped = TrainingEvaluation::query()
			->select(['id', 'training_id', 'participant_id', 'submitted_at', 'available_at'])
            ->with('participant')
            ->whereDate('available_at', '<=', $today) // -- zalegle
            ->whereNull('submitted_at') // -- jeszcze nie ocenione
            ->get();

        if ($grouped->isEmpty()) {
            $this->info('Brak zaległych ocen. Żadne maile nie zostały wysłane.');
            return self::SUCCESS;
        }

        $totalEvaluations = 0;
        $totalMails = 0;

		$mapByManager = $grouped->mapWithKeys(function($evaluation){
			$manager_id = $evaluation->participant->department->manager->id ?? 0;

			return [$manager_id => $evaluation->id];
		});

		$groupByManager = $grouped
			->filter(fn($item) => $item->participant?->department?->manager?->id !== null)
			->groupBy(fn($item) => $item->participant?->department?->manager?->id);

		//  as $evaluation) {
        //     $manager = $evaluation->participant?->department?->manager;

        //     if (! $manager?->email) {
        //         $this->warn("Przełożony ID={$manager->id} nie ma adresu email – pomijam.");
        //         continue;
        //     }

        //     $this->line("→ {$manager->full_name} <{$manager->email}> — zaległych ocen : {$evaluations->count()}");

        //     if (! $this->option('dry-run')) {
        //         Mail::to($manager->email)
        //             ->send(new OverdueEvaluationsMail(
        //                 evaluations: $evaluations,
        //                 managerName: $manager->full_name,
        //             ));
        //     }

        //     $totalEvaluations += $evaluations->count();
        //     $totalMails++;
        // }

        foreach ($groupByManager as $supervisorId => $evaluations) {
            $supervisor = $evaluations->first()->participant?->department?->manager;

            if (! $supervisor?->email) {
                $this->warn("Przełożony ID={$supervisorId} nie ma adresu email – pomijam.");
                continue;
            }

            $this->line("→ {$supervisor->full_name} <{$supervisor->email}> — {$evaluations->count()} zaległych ocen");

            if (! $this->option('dry-run')) {
                //Mail::to($supervisor->email)
				Mail::to('s.tobys@gmail.com')
                    ->send(new AvailableEvaluationsMail(
                        evaluations: $evaluations,
                        managerName: $supervisor->full_name,
                    ));
            }

            $totalEvaluations += $evaluations->count();
            $totalMails++;
        }

        $prefix = $this->option('dry-run') ? '[DRY RUN] ' : '';
        $this->info("{$prefix}Wysłano {$totalMails} maili dla {$totalEvaluations} zaległych ocen.");

        return self::SUCCESS;
    }
}
