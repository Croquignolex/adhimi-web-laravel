<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum DistanceValueEnum: string
{
    use EnumToolsTrait;

    case Meter = 'm';
    case Centimeter = 'cm';
    case Millimeter = 'mm';
}
