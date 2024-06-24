<?php

namespace Tests\RequestFactories\App\Api\Admin\Sites\Requests;

use Worksome\RequestFactories\RequestFactory;

class SiteTranslationRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'meta_title' => $this->faker->company,
            'meta_keywords' => $this->faker->words(3, true),
            'meta_desc' => substr($this->faker->words(10, true), 0, 255),
        ];
    }
}
