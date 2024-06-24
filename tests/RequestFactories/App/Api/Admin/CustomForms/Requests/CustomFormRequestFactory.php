<?php

namespace Tests\RequestFactories\App\Api\Admin\CustomForms\Requests;

use Worksome\RequestFactories\RequestFactory;

class CustomFormRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->name,
            'status' => $this->faker->boolean,
        ];
    }
}
