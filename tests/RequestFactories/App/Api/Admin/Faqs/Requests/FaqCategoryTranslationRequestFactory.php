<?php

namespace Tests\RequestFactories\App\Api\Admin\Faqs\Requests;

use Worksome\RequestFactories\RequestFactory;

class FaqCategoryTranslationRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->title
        ];
    }
}
