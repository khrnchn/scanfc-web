<?php

namespace App\Enums;

use \Spatie\Enum\Enum;

/**
 * @method static self Physical()
 * @method static self Online()
 */

final class ClassTypeEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'Physical' => 1,
            'Online' => 2,
        ];
    }
}
