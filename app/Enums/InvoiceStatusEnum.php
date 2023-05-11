<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum InvoiceStatusEnum: string
{
    use EnumToolsTrait;

    case Paid = 'Paid';
    case Pending = 'Pending';
    case Canceled = 'Canceled';
}
