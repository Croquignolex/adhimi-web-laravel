<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum LanguageEnum: string
{
    use EnumToolsTrait;

    case Fr = 'fr';
    case En = 'en';
}
