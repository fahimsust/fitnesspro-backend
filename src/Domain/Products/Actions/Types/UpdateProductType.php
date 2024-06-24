<?php

namespace Domain\Products\Actions\Types;

use App\Api\Admin\Products\Types\Requests\ProductTypeRequest;
use Domain\Products\Models\Product\ProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductType
{
    use AsObject;

    public function handle(
        ProductType $productType,
        ProductTypeRequest $request
    ): ProductType {
        $productType->update(
            [
                'name' => $request->name,
            ]
        );

        return $productType;
    }
}
