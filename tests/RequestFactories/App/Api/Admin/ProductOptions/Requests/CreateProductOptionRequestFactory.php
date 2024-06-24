<?php

namespace Tests\RequestFactories\App\Api\Admin\ProductOptions\Requests;

use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Product\Product;
use Worksome\RequestFactories\RequestFactory;

class CreateProductOptionRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->name,
            'display' => $this->faker->name,
            'type_id' => ProductOptionTypes::Select->value,
            'product_id' => Product::firstOrFactory()->id,
            'status' => true,
            'show_with_thumbnail' => false,
            'rank' => 0,
            'is_template' => false,
        ];
    }
}
