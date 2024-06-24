<?php

namespace Domain\Products\Actions\Types;

use App\Api\Admin\Products\Types\Requests\ProductTypeRequest;
use Domain\Products\Models\Product\ProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateProductType
{
    use AsObject;

    public function handle(
        ProductTypeRequest $request
    ): ProductType {
        return ProductType::create(
            [
                'name' => $request->name,
            ]
        );
    }
}
