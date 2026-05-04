<?php

namespace App\Services;

use App\Services\Tasks\Contracts\ServiceTaskInterface;
use App\Services\Tasks\QuickUserEdit;

class ServiceTaskRegistry
{
    protected array $tasks = [];

    public function __construct()
    {
		if( app()->environment('production') )
		{
			$this->register([
				//'second'	=> FixOrphanedDepartments::class,
			]);
		}

		if( app()->environment('local') )
		{
			$this->register([
				'QuickUserEdit'		=> QuickUserEdit::class,
			]);
		}
    }

    private function register(array $classes): void
    {
        foreach ($classes as $code => $class) {
            $task = app($class);
            $this->tasks[$code] = $task;
        }
    }

    public function all(): array { return $this->tasks; }

    public function find(string $code): ServiceTaskInterface
    {
        return $this->tasks[$code] ?? throw new \RuntimeException("Task not found: {$code}");
    }
}
