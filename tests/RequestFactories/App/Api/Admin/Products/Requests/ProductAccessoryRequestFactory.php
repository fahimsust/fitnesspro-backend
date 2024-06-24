<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Domain\Products\Models\Product\Product;
use Worksome\RequestFactories\RequestFactory;

class ProductAccessoryRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'product_id' => Product::firstOrFactory()->id,
            'accessory_id' => Product::factory()->create()->id,
            'required' => $this->faker->boolean,
            'show_as_option' => $this->faker->boolean,
            'discount_percentage' => $this->faker->numberBetween(0,100),
            'description' => $this->faker->word(2),
        ];
    }
}
