<?php

namespace Tests\RequestFactories\App\Api\Admin\Reviews\Requests;

use Worksome\RequestFactories\RequestFactory;

class ReviewRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'comment' => $this->faker->sentence(3),
            'rating' => rand(1,5),
        ];
    }
}
