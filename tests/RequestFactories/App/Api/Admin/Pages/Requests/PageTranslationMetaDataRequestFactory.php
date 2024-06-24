<?php

namespace Tests\RequestFactories\App\Api\Admin\Pages\Requests;

use Worksome\RequestFactories\RequestFactory;

class PageTranslationMetaDataRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'meta_title' => $this->faker->title,
            'meta_description' => $this->faker->word(2,true),
            'meta_keywords' => $this->faker->word(),
        ];
    }
}
