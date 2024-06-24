<?php

namespace Tests\RequestFactories\App\Api\Admin\Elements\Requests;

use Worksome\RequestFactories\RequestFactory;

class ElementRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'title' => $this->faker->title,
            'element_content' => $this->faker->sentence,
            'notes' => $this->faker->name,
        ];
    }
}
