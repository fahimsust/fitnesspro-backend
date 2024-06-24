<?php

namespace Tests\RequestFactories\App\Api\Orders\Requests\Cart;

use Domain\Products\Models\Product\ProductPricing;
use Worksome\RequestFactories\RequestFactory;

class AddItemToCartRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'product_id' => ProductPricing::firstOrFactory()->product_id,
            'qty' => mt_rand(1, 30)
        ];
    }
}
