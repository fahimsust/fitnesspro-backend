<?php

namespace Tests\RequestFactories\App\Api\Admin\OrderingRules\Requests;

use Worksome\RequestFactories\RequestFactory;

class OrderingRuleTranslationRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->name,
        ];
    }
}
