<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum GenderEnum: string
{
    use EnumToolsTrait;

    case Male = 'Male';
    case Female = 'Female';
    case Unknown = 'Unknown';
}
