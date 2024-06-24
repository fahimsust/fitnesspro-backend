<?php

namespace Tests\RequestFactories\App\Api\Admin\ProductOptions\Requests;

use Worksome\RequestFactories\RequestFactory;

class UpdateProductOptionRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->name,
            'display' => $this->faker->name,
            'show_with_thumbnail' => true,
            'rank' => 0,
        ];
    }
}
