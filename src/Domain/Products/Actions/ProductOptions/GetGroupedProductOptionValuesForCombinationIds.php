<?php

namespace Domain\Products\Actions\ProductOptions;

use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetGroupedProductOptionValuesForCombinationIds
{
    use AsObject;

    public function handle(
        Collection|array $arrayOfComboOptionValueIds,
    ): array
    {
        $variantsCollection = GetAwaitingVariantsCollectionFromComboIds::run($arrayOfComboOptionValueIds);
        $optionValues = [];
        foreach ($variantsCollection as $value) {
            $optionValues[] = [
                'ids' => [implode(",", $value->optionValueIds) => $value->optionValueIds],
                'display' => $this->impoldeOption($value->productOptionValues),
            ];
        }
        usort($optionValues, function ($a, $b) {
            return strcmp($a['display'], $b['display']);
        });

        return $optionValues;
    }

    private function impoldeOption($productOptionValues)
    {
        $optionValues = [];
        foreach ($productOptionValues as $productOptionValue) {
            $optionValues[] = $productOptionValue->pdisplay . " : " . $productOptionValue->real_display;
        }

        return implode(", ", $optionValues);
    }
}
