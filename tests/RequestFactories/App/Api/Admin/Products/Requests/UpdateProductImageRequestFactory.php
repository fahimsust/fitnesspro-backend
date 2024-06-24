<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Worksome\RequestFactories\RequestFactory;

class UpdateProductImageRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'caption' => $this->faker->sentence(3),
            'rank' => $this->faker->randomNumber(1),
            'show_in_gallery' => $this->faker->boolean()
        ];
    }
}
