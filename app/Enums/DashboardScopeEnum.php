<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum DashboardScopeEnum: string
{
    use EnumToolsTrait;

    case Personal = 'Personal';
    case Merchant = 'Merchant';
    case Global = 'Global';
}
