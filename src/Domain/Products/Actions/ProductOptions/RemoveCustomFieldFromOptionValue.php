<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Option\ProductOptionValue;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveCustomFieldFromOptionValue
{
    use AsObject;

    public function handle(
        ProductOptionValue     $productOptionValue,
    ): ProductOptionValue {

        if (!$productOptionValue->custom()->exists())
            throw new \Exception(
                __("Can't remove custom field from option value: no custom field set"));

        $productOptionValue->custom()->delete();

        $productOptionValue->update(['is_custom' => false]);

        return $productOptionValue->refresh();
    }
}
