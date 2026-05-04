<?php

namespace App\Livewire;

use App\Services\ServiceTaskRegistry;
use Livewire\Component;

class ServiceTaskPanel extends Component
{
	public bool $dryRunMode = false;
    public ?string $selectedTask = null;
    public array $fields = [];
    public ?array $result = null;

    public function selectTask(string $taskClass): void
    {
        $this->selectedTask = $taskClass;
        $this->fields = [];
        $this->result = null;
    }

    public function runTask(): void
    {
        $registry = app(ServiceTaskRegistry::class);
        $task = $registry->find($this->selectedTask);

        // walidacja wymaganych parametrów
        foreach ($task->parameters() as $param) {
            if ($param->required && empty($this->fields[$param->name])) {
                $this->addError($param->name, "Pole {$param->label} jest wymagane.");
                return;
            }
        }

		$result = $this->dryRunMode
				? $task->dryRun($this->fields)
				: $task->run($this->fields);

        $this->result = [
            'success' => $result->success,
            'message' => $result->message,
            'details' => $result->details,
			'dry_run' => $this->dryRunMode,
        ];
    }

    public function render()
    {
        return view('livewire.service-task-panel', [
            'tasks' => app(ServiceTaskRegistry::class)->all(),
        ]);
    }
}
