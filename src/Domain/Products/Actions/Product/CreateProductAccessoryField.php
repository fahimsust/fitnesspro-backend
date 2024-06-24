<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductAccessoryFieldRequest;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateProductAccessoryField
{
    use AsObject;

    public function handle(
        Product $product,
        ProductAccessoryFieldRequest $request,
    ): Collection {
        $product->productAccessoryFields()->updateOrCreate(
            [
                'accessories_fields_id' => $request->accessories_fields_id,
            ],
            [
                'rank' => $request->rank
            ]
        );
        return $product->productAccessoryFields;
    }
}
