<?php

namespace Tests\RequestFactories\App\Api\Admin\OrderingRules\Requests;

use Worksome\RequestFactories\RequestFactory;

class OrderingRuleRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->name,
            'any_all' => $this->faker->randomElement(['any','all']),
        ];
    }
}
