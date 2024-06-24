<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\RelatedProductRequest;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateRelatedProduct
{
    use AsObject;

    public function handle(
        Product $product,
        RelatedProductRequest $request,
    ): Collection {
        $product->productRelated()->updateOrCreate(
            [
                'related_id' => $request->related_id,
            ]
        );

        return $product->relatedProducts;
    }
}
