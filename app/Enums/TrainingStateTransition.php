<?php

namespace App\Enums;

use JsonSerializable;
use App\Traits\EnumToArray;

enum TrainingStateTransition: string implements JsonSerializable
{
    use EnumToArray;

    case SEND_BACK_TO_DRAFT = 'send_back_to_draft';
    case SUBMIT_FOR_APPROVAL = 'submit_for_approval';
    case DM_APPROVES = 'dm_approves';
    case HR_APPROVES = 'hr_approves';
    case FICO_APPROVES = 'fico_approves';
    case PM_APPROVES = 'pm_approves';
    case WITHDRAW = 'withdraw';
    case REJECT = 'reject';

    public function label(): string
    {
        return match($this) {
            self::ONSITE => 'On Site',
            self::OFFSITE => 'Off Site',
            self::ONLINE => 'Online',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ONSITE => 'gray',
            self::OFFSITE => 'blue',
            self::ONLINE => 'green',
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
