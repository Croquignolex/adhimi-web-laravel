<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait CurrencyAmountTrait
{
    /**
     * Determine formatted amount with currency, magic attribute $this->currency_amount.
     *
     * @return Attribute
     */
    public function currencyAmount(): Attribute
    {
        return new Attribute(
            get: fn () => "FCFA " . number_format($this->amount)
        );
    }
}
