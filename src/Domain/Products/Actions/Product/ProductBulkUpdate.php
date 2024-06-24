<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsObject;

class ProductBulkUpdate
{
    use AsObject;

    public function handle(
        Request $request,
        string $fieldName,
    ) {
        Product::whereIn('id',$request->products)->get()->each(
            fn (Product $product) => $product->update(
                [
                    $fieldName => $request->input($fieldName)
                ]
            )
        );
    }
}
