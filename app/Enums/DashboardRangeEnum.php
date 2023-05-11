<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum DashboardRangeEnum: string
{
    use EnumToolsTrait;

    case Daily = 'Daily';
    case Weekly = 'Weekly';
    case Monthly = 'Monthly';
    case Yearly = 'Yearly';
}
