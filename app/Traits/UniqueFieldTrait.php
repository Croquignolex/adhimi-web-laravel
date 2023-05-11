<?php

namespace App\Traits;

use App\Enums\AutoUniqueModelFieldEnum;
use App\Models\Invoice;
use App\Models\Payment;

trait UniqueFieldTrait
{
    /**
     * @param string $prefix
     * @param AutoUniqueModelFieldEnum $model
     * @return string|void
     */
    private function uniqueField(string $prefix, AutoUniqueModelFieldEnum $model)
    {
        $uniqueFiled = uniqid($prefix . date("Y"));

        $recursiveCondition = match ($model) {
            AutoUniqueModelFieldEnum::Payment => Payment::whereReference($uniqueFiled),
            AutoUniqueModelFieldEnum::Invoice => Invoice::whereReference($uniqueFiled),
        };

        if ($recursiveCondition->count() > 0) {
            $this->uniqueField($prefix, $model);
        } else {
            return $uniqueFiled;
        }
    }
}
