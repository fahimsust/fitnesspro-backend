<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductAccessoryRequest;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateProductAccessory
{
    use AsObject;

    public function handle(
        Product $product,
        ProductAccessoryRequest $request,
    ): Collection {
        $product->productAccessories()->updateOrCreate(
            [
                'accessory_id' => $request->accessory_id,
            ],
            [
                'required' => $request->required,
                'show_as_option' => $request->show_as_option,
                'discount_percentage' => $request->discount_percentage,
                'link_actions' => $request->link_actions,
                'description' => $request->description,
            ]
        );
        return $product->productAccessories;
    }
}
