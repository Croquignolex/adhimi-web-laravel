<?php

namespace App\Observers;

use App\Enums\AutoUniqueModelFieldEnum;
use App\Models\Invoice;

class InvoiceObserver
{

    /**
     * Handle the Invoice "creating" event.
     *
     * @param Invoice $invoice
     * @return void
     */
    public function creating(Invoice $invoice): void
    {
        // $invoice->reference = $this->uniqueField("HAI",AutoUniqueModelFieldEnum::Invoice);
    }
}
