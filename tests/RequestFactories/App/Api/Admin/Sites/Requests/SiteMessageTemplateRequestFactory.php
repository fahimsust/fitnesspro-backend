<?php

namespace Tests\RequestFactories\App\Api\Admin\Sites\Requests;

use Worksome\RequestFactories\RequestFactory;

class SiteMessageTemplateRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'html'=>$this->faker->text,
            'alt'=>$this->faker->text
        ];
    }
}
