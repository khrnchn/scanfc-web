<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self Accepted()
 * @method static self Rejected()
 * @method static self WaitingForApproval()
 */

final class ExemptionStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'ExemptionNeeded' => 1,
            'ExemptionSubmitted' => 2,
        ];
    }

    protected static function labels(): array
    {
        return [
            'ExemptionNeeded' => __('Exemption needed'),
            'ExemptionSubmitted' => __('Exemption submitted'),
        ];
    }
}
