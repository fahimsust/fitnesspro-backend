<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Worksome\RequestFactories\RequestFactory;

class ProductBasicsRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'subtitle' => $this->faker->title,
            'title' => $this->faker->title,
            'url_name' => $this->faker->unique()->slug(2),
            'product_no' => $this->faker->word,
            'weight'=>$this->faker->randomNumber(2)
        ];
    }
}
