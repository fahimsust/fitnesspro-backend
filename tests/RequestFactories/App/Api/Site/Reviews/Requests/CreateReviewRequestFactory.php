<?php

namespace Tests\RequestFactories\App\Api\Site\Reviews\Requests;

use Worksome\RequestFactories\RequestFactory;

class CreateReviewRequestFactory extends RequestFactory
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
