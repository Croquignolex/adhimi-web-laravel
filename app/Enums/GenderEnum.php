<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum GenderEnum: string
{
    use EnumToolsTrait;

    case Male = 'male';
    case Female = 'female';
    case Unknown = 'unknown';
}
