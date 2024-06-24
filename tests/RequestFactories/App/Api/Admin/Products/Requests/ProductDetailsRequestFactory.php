<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Worksome\RequestFactories\RequestFactory;

class ProductDetailsRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'summary'=>$this->faker->text,
            'description'=>$this->faker->text,
            'product_attributes'=>$this->faker->text,
        ];
    }
}
