<?php

namespace Domain\Products\Actions\Product;

use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductForm;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductForm
{
    use AsObject;

    public function handle(
        Product $product,
        CustomForm $customForm
    ): ProductForm {
        return $product->productForms()->whereFormId($customForm->id)->firstOrFail();
    }
}
