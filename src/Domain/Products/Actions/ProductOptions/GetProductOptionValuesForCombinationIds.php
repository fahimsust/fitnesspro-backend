<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\QueryBuilders\ProductOptionValueQuery;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductOptionValuesForCombinationIds
{
    use AsObject;

    public function handle(
        Collection|array $arrayOfComboOptionValueIds,
    ): Collection
    {

        return ProductOptionValue::query()
            ->forOptionValueComboIds($arrayOfComboOptionValueIds)
            ->with('option')
            ->select(
                "id",
                "option_id",
                "display",
                ProductOptionValueQuery::realDisplaySelect(),
            )
            ->get();
    }

}
