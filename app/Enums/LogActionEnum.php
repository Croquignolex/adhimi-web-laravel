<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum LogActionEnum: string
{
    use EnumToolsTrait;

    case Create = 'Create';
    case Update = 'Update';
    case Auth = 'Auth';
    case Delete = 'Delete';
    case Custom = 'Custom';
}
