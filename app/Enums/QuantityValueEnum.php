<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum QuantityValueEnum: string
{
    use EnumToolsTrait;

    case Liter = 'l';
    case CubicCentimeter = 'cm3';
}
