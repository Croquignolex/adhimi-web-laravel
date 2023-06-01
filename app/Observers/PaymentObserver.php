<?php

namespace App\Observers;

use App\Enums\AutoUniqueModelFieldEnum;
use App\Models\Payment;

class PaymentObserver
{

    /**
     * Handle the Payment "creating" event.
     *
     * @param Payment $payment
     * @return void
     */
    public function creating(Payment $payment): void
    {
        //$payment->reference = $this->uniqueField("HAP", AutoUniqueModelFieldEnum::Payment);
    }
}
