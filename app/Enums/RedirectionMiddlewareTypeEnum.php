<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum RedirectionMiddlewareTypeEnum: string
{
    use EnumToolsTrait;

    case Guest = 'guest';
    case Auth = 'auth';
    case Active = 'active';
    case NotAdmin = 'admin';
    case NotSuperAdmin = 'super';
    case NotShopManager = 'manager';
    case NotMerchant = 'merchant';
    case NotSaler = 'saler';
}
