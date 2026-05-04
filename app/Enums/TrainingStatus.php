<?php

namespace App\Enums;

use JsonSerializable;
use App\Traits\EnumToArray;
use App\Traits\EnumFromName;

enum TrainingStatus: int implements JsonSerializable
{

    use EnumToArray, EnumFromName;

    case PLANNED = 1;
    case CANCELLED = 2;
    case REALIZED = 4;
    case TRAINING_EVALUATED = 8;
    case EFFECTIVENESS_EVALUATED = 16;
    case FINISHED = 32;

    public function label(): string
    {
        return match($this) {
            self::PLANNED => __('trainings.status.planned'),
            self::CANCELLED => __('trainings.status.cancelled'),
            self::REALIZED => __('trainings.status.realized'),
            self::TRAINING_EVALUATED => __('trainings.status.training_evaluated'),
            self::EFFECTIVENESS_EVALUATED => __('trainings.status.effectiveness_evaluated'),
            self::FINISHED => __('trainings.status.finished'),
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PLANNED => '#ffc107',
            self::CANCELLED => '#dc3545',
            self::REALIZED => '#28a745',
            self::TRAINING_EVALUATED => '#fb7d07', // '#fd7e14',
            self::EFFECTIVENESS_EVALUATED => '#fb7d07', // '#fd7e14',
            self::FINISHED => '#155724',
        };
    }

    public function jsonSerialize(): mixed
    {
        return [
            'value' => $this->value,
            'name' => $this->name,
            'label' => $this->label(),
            'color' => $this->color(),
        ];
    }

    public function isPlanned(): bool
    {
        return $this === self::PLANNED;
    }

    public function isCancelled(): bool
    {
        return $this === self::CANCELLED;
    }

    public function isRealized(): bool
    {
        return $this === self::REALIZED;
    }

    public function isTrainingEvaluated(): bool
    {
        return $this === self::TRAINING_EVALUATED;
    }

    public function isEffectivenessEvaluated(): bool
    {
        return $this === self::EFFECTIVENESS_EVALUATED;
    }

    public function isFinished(): bool
    {
        return $this === self::FINISHED;
    }
}
