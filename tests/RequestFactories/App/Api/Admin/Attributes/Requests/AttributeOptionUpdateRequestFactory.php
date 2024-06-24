<?php

namespace Tests\RequestFactories\App\Api\Admin\Attributes\Requests;

use Worksome\RequestFactories\RequestFactory;

class AttributeOptionUpdateRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'display' => $this->faker->title,
            'rank' => $this->faker->randomDigit,
            'status' => $this->faker->boolean,
        ];
    }
}
