<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum AddressTypeEnum: string
{
    use EnumToolsTrait;

    case Billing = 'Billing';
    case Shipping = 'Shipping';
    case Default = 'Default';
}
