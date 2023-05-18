<?php

namespace App\Enums;

use App\Traits\EnumToolsTrait;

enum PaiementMethodEnum: string
{
    use EnumToolsTrait;

    case CashOnDelivery = 'Cash on delivery';
    case OrangeMoney = 'Orange Money';
    case MTNMobileMoney = 'MTN Mobile Money';
    case Stripe = 'Stripe';
    case Paypal = 'Paypal';
}
