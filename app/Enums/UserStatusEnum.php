<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum UserStatusEnum: string
{
    use EnumToolsTrait;

    case Active = 'Active';
    case Blocked = 'Blocked';
}
