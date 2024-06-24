<?php

namespace Tests\RequestFactories\App\Api\Admin\Faqs\Requests;

use Worksome\RequestFactories\RequestFactory;

class FaqTranslationRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'question' => $this->faker->title,
            'answer' => $this->faker->words(3, true)
        ];
    }
}
