<?php

namespace App\Enums;

use JsonSerializable;
use App\Traits\EnumToArray;
use App\Traits\EnumFromName;

enum TrainingType: int implements JsonSerializable
{
    use EnumToArray, EnumFromName;

    case ONSITE = 1;
    case OFFSITE = 2;
    case ONLINE = 4;

    public function label(): string
    {
        return match($this) {
            self::ONSITE => __('trainings.type.on-site'),
            self::OFFSITE => __('trainings.type.off-site'),
            self::ONLINE => __('trainings.type.online'),
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ONSITE => 'green',
            self::OFFSITE => 'yellow',
            self::ONLINE => 'blue',
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

    public static function getOptions(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }

    // public function isFinalized(): bool
    // {
    //     return in_array($this, [self::COMPLETED, self::CANCELLED, self::REFUNDED]);
    // }
}
