<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum UserRoleEnum: string
{
    use EnumToolsTrait;

    case Customer = 'customer';
    case Seller = 'seller';
    case Admin = 'admin';
    case Merchant = 'merchant';
    case ShopManager = 'shop_manager';
    case SuperAdmin = 'super_admin';
}
