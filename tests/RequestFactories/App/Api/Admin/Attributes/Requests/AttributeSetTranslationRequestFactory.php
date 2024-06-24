<?php

namespace Tests\RequestFactories\App\Api\Admin\Attributes\Requests;

use Worksome\RequestFactories\RequestFactory;

class AttributeSetTranslationRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->title,
        ];
    }
}
