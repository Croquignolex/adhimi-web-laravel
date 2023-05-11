<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum AutoUniqueModelFieldEnum: string
{
    use EnumToolsTrait;

    case Invoice = 'Invoice';
    case Payment = 'Payment';
}
