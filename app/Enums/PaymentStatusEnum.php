<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum PaymentStatusEnum: string
{
    use EnumToolsTrait;

    case Failed = 'Failed';
    case Canceled = 'Canceled';
    case Successful = 'Successful';
}
