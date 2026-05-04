<?php

namespace App\Services\Tasks;

use App\Models\Training;
use App\Services\Tasks\BaseServiceTask;
use App\Services\Tasks\TaskResult;

class FixOrphanedTrainings extends BaseServiceTask
{
    public function parameters(): array
    {
        return [
            ['name' => 'training_id', 'type' => 'number', 'label' => 'ID szkolenia', 'required' => true],
            ['name' => 'user_id',     'type' => 'number', 'label' => 'ID użytkownika', 'required' => true],
        ];
    }

    public function run(array $params = []): TaskResult
    {
        $training = Training::findOrFail($params['training_id']);
        $training->participants()->detach($params['user_id']);

        return TaskResult::ok('Uczestnik usunięty ze szkolenia.');
    }
}
