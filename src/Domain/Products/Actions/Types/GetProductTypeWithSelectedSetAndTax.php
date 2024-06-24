<?php

namespace Domain\Products\Actions\Types;

use Illuminate\Http\Request;
use Domain\Products\Models\Product\ProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductTypeWithSelectedSetAndTax
{
    use AsObject;

    public function handle(
        Request $request
    ) {
        $productTypes = ProductType::query()
            ->with('attributeSets', 'taxRules')
            ->search($request)
            ->paginate($request?->per_page);


        $productTypes->getCollection()->transform(function ($productType, $key) {
            return [
                'id'=>$productType->id,
                'name'=>$productType->name,
                'attribute_sets'=>$productType->attributeSets,
                'selectedAttributeSet' => $productType->attributeSets->pluck('id')->toArray(),
                'selectedTaxRules' => $productType->taxRules->pluck('id')->toArray()
            ];
        });


        return $productTypes;
    }
}
