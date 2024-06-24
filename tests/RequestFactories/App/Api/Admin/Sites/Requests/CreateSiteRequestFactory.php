<?php

namespace Tests\RequestFactories\App\Api\Admin\Sites\Requests;

use Worksome\RequestFactories\RequestFactory;

class CreateSiteRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'domain' => $this->faker->domainName,
            'email' => $this->faker->email,
            'url' => $this->faker->url,
            'meta_title' => $this->faker->company,
            'meta_keywords' => $this->faker->words(3, true),
            'meta_desc' => substr($this->faker->words(10, true), 0, 255),
            'logo_url' => $this->faker->url,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
