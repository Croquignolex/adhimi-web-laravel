<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum InventoryConditionEnum: string
{
    use EnumToolsTrait;

    case New = 'new';
    case Used = 'used';
    case Refurbished = 'refurbished';
}
