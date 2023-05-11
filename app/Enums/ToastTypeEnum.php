<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum ToastTypeEnum: string
{
    use EnumToolsTrait;

    case Info = 'info';
    case Success = 'success';
    case Warning = 'warning';
    case Danger = 'danger';
}
