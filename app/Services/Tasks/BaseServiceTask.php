<?php

// app/Services/Tasks/BaseServiceTask.php

namespace App\Services\Tasks;

use App\Services\Tasks\Contracts\ServiceTaskInterface;

abstract class BaseServiceTask implements ServiceTaskInterface
{
    public function parameters(): array
    {
        return [];
    }

    public function supportsDryRun(): bool
    {
        return false;  // domyślnie wyłączone, task musi opt-in
    }

    public function dryRun(array $params = []): TaskResult
    {
        return TaskResult::fail('Ten task nie obsługuje dry-run.');
    }

}
