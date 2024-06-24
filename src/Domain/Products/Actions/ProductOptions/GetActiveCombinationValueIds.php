<?php

namespace Domain\Products\Actions\ProductOptions;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class GetActiveCombinationValueIds
{
    use AsObject;

    public function handle(
        Product $parentProduct
    ): array
    {
        return iterator_to_array(
            $this->generateCombinations(
                ProductOption::combinationOptionValuesGrouped($parentProduct->id)
                    ->get()
                    ->map(
                        fn(ProductOption $option) => explode(",", $option->option_value_ids_string)
                    )->toArray()
            ),
            false
        );
    }

    private function generateCombinations(array $array): \Generator
    {
        foreach (array_pop($array) as $value) {
            if (count($array)) {
                foreach ($this->generateCombinations($array) as $combination) {
                    yield array_merge([$value], $combination);
                };
            } else {
                yield [$value];
            }
        }
    }

}
