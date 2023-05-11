<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum GeneralStatusEnum: string
{
    use EnumToolsTrait;

    case Enable = 'Enable';
    case StandBy = 'Stand By';
    case Disable = 'Disable';
}
