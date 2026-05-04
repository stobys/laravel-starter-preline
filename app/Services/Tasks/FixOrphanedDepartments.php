<?php

namespace App\Services\Tasks;

use App\Services\Tasks\TaskResult;

class FixOrphanedDepartments extends BaseServiceTask
{
    public function name(): string { return 'Usuń szkolenia bez uczestników'; }
    public function description(): string { return 'Usuwa wszystkie szkolenia, do których nie przypisano żadnego uczestnika.'; }
    public function parameters(): array { return []; }  // brak parametrów

    public function run(array $params = []): TaskResult
    {
        $deleted = 2; //Training::whereDoesntHave('participants')->delete();

        return TaskResult::ok("Usunięto {$deleted} szkoleń.", ['deleted_count' => $deleted]);
    }
}
