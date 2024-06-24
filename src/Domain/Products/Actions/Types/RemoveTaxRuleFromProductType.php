<?php

namespace Domain\Products\Actions\Types;

use Domain\Products\Models\Product\ProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveTaxRuleFromProductType
{
    use AsObject;

    public function handle(
        ProductType $productType,
        int $tax_rule_id,
    ) {
        if (! IsTaxRuleAssignedToProductType::run($productType, $tax_rule_id)) {
            throw new \Exception(__('Attribute Set not assigned to product type'));
        }

        $productType->taxRuleProductType()->whereTaxRuleId($tax_rule_id)->delete();
    }
}
