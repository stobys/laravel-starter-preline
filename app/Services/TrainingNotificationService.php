<?php

namespace App\Services;


use App\Models\Training;
use App\Models\User;

use App\Notifications\TrainingFullyApproved;

use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TrainingNotificationService
{
    protected $training_id = null;

    public function setTrainingId(int $training_id) {
        $this->training_id = $training_id;

        return $this;
    }

    public function query($with_filter = false) {
        return ScheduledNotification::query();
    }



}
