<?php

namespace App\Services\Tasks\Contracts;

use App\Services\Tasks\TaskResult;

interface ServiceTaskInterface
{
    public function name(): string;
    public function description(): string;
    public function parameters(): array;  // definicja parametrów (nazwa, typ, wymagany)
    public function run(array $params = []): TaskResult;
	public function dryRun(array $params = []): TaskResult;
    public function supportsDryRun(): bool;
}
