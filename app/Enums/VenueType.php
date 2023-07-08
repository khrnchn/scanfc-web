<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class VenueType extends Enum
{
    const DewanKuliah = 0;
    const DewanSeminar = 1;
    const BilikKuliah = 2;
}
