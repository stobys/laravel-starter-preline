<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\TrainingProvider;
use App\Actions\TrainingProvider\ToggleActivity;
use App\Actions\TrainingProvider\StoreTrainingProvider;
use App\Actions\TrainingProvider\UpdateTrainingProvider;
use App\Actions\TrainingProvider\DestroyTrainingProvider;

class TrainingProviderService
{

    public function __construct(
        private readonly StoreTrainingProvider $storeAction,
        private readonly UpdateTrainingProvider $updateAction,
        private readonly DestroyTrainingProvider $destroyAction,
        private readonly ToggleActivity $toggleActivityAction
    ) {}

    public  function query($with_filter = false) {
        return TrainingProvider::query();
    }

    // -- passing validated $data from controller to service
    public function store(array $data)
    {
        $model = $this->storeAction->handle($data);

        return [
            'errno' => $model->exists ? 0 : 1,
            'errmsg' => $model->exists ? 'TrainingProvider saved successfully' : 'TrainingProvider not saved',
            'model' => $model
        ];
    }

    // -- passing validated $data from controller to service
    public function update(TrainingProvider $provider, array $data)
    {
        $model = $this->updateAction->handle($provider, $data);

        // $training->logStateTransition($data['state']);

        return [
            'errno' => $model->exists ? 0 : 1,
            'errmsg' => $model->exists ? 'TrainingProvider saved successfully' : 'TrainingProvider not saved',
            'model' => $model
        ];
    }

    public function destroy(TrainingProvider $model)
    {
        $isDeleted = $this->destroyAction->handle($model);

        // $training->logStateTransition($data['state']);

        return [
            'errno' => $isDeleted ? 0 : 1,
            'errmsg' => $isDeleted ? 'TrainingProvider deleted successfully' : 'TrainingProvider not deleted',
            'model' => null
        ];
    }

    public function toggleActivity(TrainingProvider $model)
    {
        $model = $this->toggleActivityAction->handle($model);

        return [
            'errno' => $model->exists ? 0 : 1,
            'errmsg' => $model->exists ? 'TrainingProvider saved successfully' : 'TrainingProvider not saved',
            'model' => $model
        ];
    }

    public function getExportFileName()
    {
        $baseName = Str::studly(TrainingProvider::getTableName());
        return sprintf('%s-%s.csv', $baseName, now()->format('YmdHis'));
    }
}
