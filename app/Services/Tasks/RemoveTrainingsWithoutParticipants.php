<?php

namespace App\Services\Tasks;

use App\Models\Training;

class RemoveTrainingsWithoutParticipants extends BaseServiceTask
{
    public function name(): string { return __('RemoveTrainingsWithoutParticipants'); }
    public function description(): string { return __('Removes every training that has no participants assigned'); }

    public function run(array $params = []): TaskResult
    {
        $deleted = Training::whereDoesntHave('participants')->delete();
        return TaskResult::ok("Usunięto {$deleted} szkoleń.", ['deleted_count' => $deleted]);
    }

    public function supportsDryRun(): bool { return true; }

    public function dryRun(array $params = []): TaskResult
    {
        $trainings = Training::whereDoesntHave('participants')->get();

        return TaskResult::ok(
            "Dry-run: znaleziono {$trainings->count()} szkoleń do usunięcia.",
            ['would_delete' => $trainings->pluck('id', 'name')->toArray()]
        );
    }

}
