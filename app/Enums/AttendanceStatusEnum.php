<?php

namespace App\Enums;

use \Spatie\Enum\Enum;

/**
 * @method static self Present()
 * @method static self Absent()
 * @method static self Error()
 */

final class AttendanceStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'Present' => 1,
            'Absent' => 2,
            'Error' => 3,
        ];
    }
}
