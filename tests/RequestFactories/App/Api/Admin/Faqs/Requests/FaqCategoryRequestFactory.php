<?php

namespace Tests\RequestFactories\App\Api\Admin\Faqs\Requests;

use Worksome\RequestFactories\RequestFactory;

class FaqCategoryRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'status' => $this->faker->boolean,
            'rank' => $this->faker->numberBetween(1,10),
            'url' => $this->faker->unique()->slug(2)
        ];
    }
}
