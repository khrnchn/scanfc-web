<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self Accepted()
 * @method static self Rejected()
 * @method static self WaitingForApproval()
 */

final class AttendanceStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'Present' => 1,
            'Absent' => 2,
        ];
    }
}
