<?php

namespace Tests\RequestFactories\App\Api\Admin\Sites\Requests;

use Worksome\RequestFactories\RequestFactory;

class SiteOfflineMessageTranslationRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'offline_message' => substr($this->faker->words(10, true), 0, 255),
        ];
    }
}
