<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum UserRoleEnum: string
{
    use EnumToolsTrait;

    case Customer = 'Customer';
    case Saler = 'Saler';
    case Admin = 'Admin';
    case Merchant = 'Merchant';
    case ShopManager = 'Shop Manager';
    case SuperAdmin = 'Super Admin';
}
