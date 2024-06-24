<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\QueryBuilders\ProductOptionValueQuery;
use Domain\Products\ValueObjects\AwaitingVariantOptionValuesComboVo;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetAwaitingVariantsCollectionFromComboIds
{
    use AsObject;

    public function handle(
        Collection $collectionOfComboOptionValueIds
    ): Collection
    {
        $productOptionValues = ProductOptionValue::query()
            ->forOptionValueComboIds($collectionOfComboOptionValueIds)
            ->joinRelationship('option')
            ->select(
                "products_options.display as pdisplay",
                "products_options_values.option_id",
                "products_options_values.id",
                "products_options_values.display",
                ProductOptionValueQuery::realDisplaySelect("products_options_values.display"),
            )
            ->get();

        return $collectionOfComboOptionValueIds->mapWithKeys(
            fn(array $optionValueIds) => [
                implode(",", $optionValueIds) => new AwaitingVariantOptionValuesComboVo(
                    $optionValueIds,
                    $productOptionValues->whereIn('id', $optionValueIds),
                )
            ]
        );
    }
}
