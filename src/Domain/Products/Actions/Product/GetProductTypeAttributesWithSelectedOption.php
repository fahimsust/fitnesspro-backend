<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductIdRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductTypeAttributesWithSelectedOption
{
    use AsObject;

    public function handle(
        ProductIdRequest $request
    )
    {
        $product = Product::with('details')
            ->findOrFail($request->product_id);

        if (!isset($product->details->type_id)) {
            return [];
        }

        $productAttributes = ProductAttribute::whereProductId($request->product_id)->get();

        $productTypeWithAttributes = ProductType::with('attributeSets.attributes.options')
            ->findOrFail($product->details->type_id);

        if (!$productTypeWithAttributes) {
            return [];
        }

        foreach ($productTypeWithAttributes->attributeSets as $attributeSet) {
            $attributeSet->attributes
                ->transform(function ($attribute, $key) use ($productAttributes) {
                    $selected_options = [];
                    foreach ($attribute->options as $option) {
                        foreach ($productAttributes as $value) {
                            if ($value->option_id == $option->id) {
                                $selected_options[] = $option->id;
                            }
                        }
                    }

                    return [
                        'selected' => $selected_options,
                        'id' => $attribute->id,
                        'name' => $attribute->name,
                        'type_id' => $attribute->type_id,
                        'options' => $attribute->options
                    ];
                });
        }

        return $productTypeWithAttributes ?? [];
    }
}
