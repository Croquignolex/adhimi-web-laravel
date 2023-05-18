<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum WeightValueEnum: string
{
    use EnumToolsTrait;

    case Kilogramme = 'kg';
    case Gramme = 'g';
    case Tonne = 't';
}
