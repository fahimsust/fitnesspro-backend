<?php

namespace Tests\RequestFactories\App\Api\Admin\Attributes\Requests;

use Worksome\RequestFactories\RequestFactory;

class AttributeOptionTranslationRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'display' => $this->faker->title,
        ];
    }
}
