<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum PaymentProviderEnum: string
{
    use EnumToolsTrait;

    case MTN = 'CM_MTNMOBILEMONEY';
    case ORANGE = 'CM_ORANGEMONEY';
}
