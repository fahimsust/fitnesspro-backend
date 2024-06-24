<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\ProductVariantOption;
use Lorisleiva\Actions\Concerns\AsObject;

class GetOptionsForVariant
{
    use AsObject;

    public function handle(int $variantId): array
    {
        $options = [];

        ProductVariantOption::select(
            'optionValue.id',
            'optionValue.option_id',
            'option.type_id'
        )
            ->whereProductId($variantId)
            ->joinRelationship(
                'option',
                fn ($join) => $join->as('option')
            )
            ->joinRelationship(
                'optionValue',
                fn ($join) => $join->as('optionValue')
            )
            ->where('optionValue.status', 1)
            ->where('option.status', 1)
            ->groupBy('optionValue.id')
            ->get()
            ->map(
                function (ProductVariantOption $variantOption) use ($options) {
                    if (in_array($variantOption->type_id, [1, 3, 4])) {
                        $options[$variantOption->option_id] = $variantOption->id;
                        return;
                    }

                    $options[$variantOption->option_id][] = $variantOption->id;
                }
            );

        return $options;
    }
}
