<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum LogActionEnum: string
{
    use EnumToolsTrait;

    case Create = 'create';
    case Update = 'update';
    case Auth = 'auth';
    case Delete = 'delete';
    case Other = 'other';
}
