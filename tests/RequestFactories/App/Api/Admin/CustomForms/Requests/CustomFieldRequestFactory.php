<?php

namespace Tests\RequestFactories\App\Api\Admin\CustomForms\Requests;

use Worksome\RequestFactories\RequestFactory;

class CustomFieldRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->name,
            'display' => $this->faker->name,
            'required' => $this->faker->boolean,
            'status' => $this->faker->boolean,
            'rank' => 1,
            'type' => 0,
        ];
    }
}
