<?php

namespace Tests\RequestFactories\App\Api\Admin\Categories\Requests;

use Worksome\RequestFactories\RequestFactory;

class CategoryTranslationMetaDataRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'meta_title' => $this->faker->title,
            'meta_desc' => $this->faker->word(2,true),
            'meta_keywords' => $this->faker->word(),
        ];
    }
}
