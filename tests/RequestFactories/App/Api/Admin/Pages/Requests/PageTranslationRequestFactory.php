<?php

namespace Tests\RequestFactories\App\Api\Admin\Pages\Requests;

use Worksome\RequestFactories\RequestFactory;

class PageTranslationRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'title' => $this->faker->title,
            'url_name' => $this->faker->unique()->slug(2),
            'page_content' => $this->faker->sentence,
        ];
    }
}
