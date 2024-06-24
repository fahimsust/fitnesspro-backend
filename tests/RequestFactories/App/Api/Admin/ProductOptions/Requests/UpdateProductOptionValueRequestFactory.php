<?php

namespace Tests\RequestFactories\App\Api\Admin\ProductOptions\Requests;

use Worksome\RequestFactories\RequestFactory;

class UpdateProductOptionValueRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'display' => $this->faker->name,
            'name' => $this->faker->name,
            'price' =>$this->faker->randomDigit,
            'rank' => $this->faker->randomDigit,
        ];
    }
}
