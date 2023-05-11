<?php

namespace App\Observers;

use App\Enums\AutoUniqueModelFieldEnum;
use App\Traits\UniqueFieldTrait;
use App\Models\Invoice;

class InvoiceObserver
{
    use UniqueFieldTrait;

    /**
     * Handle the Invoice "creating" event.
     *
     * @param Invoice $invoice
     * @return void
     */
    public function creating(Invoice $invoice): void
    {
        $invoice->reference = $this->uniqueField("HAI",AutoUniqueModelFieldEnum::Invoice);
    }
}
