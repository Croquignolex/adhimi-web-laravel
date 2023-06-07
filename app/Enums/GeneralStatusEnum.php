<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum GeneralStatusEnum: string
{
    use EnumToolsTrait;

    case Enable = 'enable';
    case StandBy = 'stand_ty';
    case Disable = 'disable';
}
