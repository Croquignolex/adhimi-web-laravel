<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum MiddlewareTypeEnum: string
{
    use EnumToolsTrait;

    case Guest = 'guest';
    case Auth = 'auth';
    case Admin = 'admin';
    case SuperAdmin = 'super';
    case Customer = 'customer';
    case ShopManager = 'manager';
    case Merchant = 'merchant';
    case Seller = 'seller';
}
