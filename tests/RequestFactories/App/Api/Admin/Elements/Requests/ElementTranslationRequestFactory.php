<?php

namespace Tests\RequestFactories\App\Api\Admin\Elements\Requests;

use Worksome\RequestFactories\RequestFactory;

class ElementTranslationRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'element_content' => $this->faker->sentence,
        ];
    }
}
