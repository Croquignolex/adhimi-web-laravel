<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum LanguageEnum: string
{
    use EnumToolsTrait;

    case French = 'fr';
    case English = 'en';
}
