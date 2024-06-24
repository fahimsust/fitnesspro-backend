<?php

namespace Tests\RequestFactories\App\Api\Admin\MessageTemplates\Requests;

use Worksome\RequestFactories\RequestFactory;

class MessageTemplateTranslationRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'subject' => $this->faker->words(4, true),
            'alt_body' => $this->faker->paragraphs(3, true),
            'html_body' => $this->faker->randomHtml(3),
        ];
    }
}
