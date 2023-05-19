<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum RedirectionMiddlewareTypeEnum: string
{
    use EnumToolsTrait;

    case Guest = 'guest';
    case Auth = 'auth';
    case NotAdmin = 'admin';
    case NotSuperAdmin = 'super';
    case NotCustomer = 'customer';
    case NotShopManager = 'manager';
    case NotMerchant = 'merchant';
    case NotSaler = 'saler';
}
