<?php

namespace Domain\Products\Actions\Types;

use Domain\Products\Models\Product\ProductType;
use Domain\Tax\Models\TaxRuleProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class IsTaxRuleAssignedToProductType
{
    use AsObject;

    public function handle(
        ProductType $productType,
        int $tax_rule_id,
    ): ?TaxRuleProductType {
        return $productType->taxRuleProductType()->whereTaxRuleId($tax_rule_id)->first();
    }
}
