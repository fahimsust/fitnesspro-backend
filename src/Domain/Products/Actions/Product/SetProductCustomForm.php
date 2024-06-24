<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductFormRequest;
use Domain\CustomForms\Models\ProductForm;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class SetProductCustomForm
{
    use AsObject;

    public function handle(
        Product $product,
        ProductFormRequest $request
    ): ProductForm {
        return $product->productForms()->updateOrCreate(
            [
                'form_id' => $request->form_id,
            ],
            [
                'rank' => $request->rank,
            ]
        );
    }
}
