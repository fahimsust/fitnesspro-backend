<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Worksome\RequestFactories\RequestFactory;

class ProductTranslationBasicsRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'subtitle' => $this->faker->title,
            'title' => $this->faker->title,
            'url_name' => $this->faker->unique()->slug(2),
        ];
    }
}
