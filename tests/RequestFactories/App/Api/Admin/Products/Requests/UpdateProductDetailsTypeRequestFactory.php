<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Domain\Products\Models\Product\ProductType;
use Worksome\RequestFactories\RequestFactory;

class UpdateProductDetailsTypeRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'type_id' => ProductType::firstOrFactory()->id,
        ];
    }
}
