<?php

namespace Tests\RequestFactories\App\Api\Admin\Sites\Requests;

use Worksome\RequestFactories\RequestFactory;

class UpdateSiteRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'domain' => $this->faker->domainName,
            'email' => $this->faker->email,
            'url' => $this->faker->url,
            'logo_url' => $this->faker->url,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
