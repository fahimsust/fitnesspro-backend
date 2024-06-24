<?php

namespace Tests\RequestFactories\App\Api\Admin\Discounts\Requests;

use Domain\Discounts\Enums\DiscountLevelActionType;
use Domain\Discounts\Enums\DiscountLevelApplyTo;
use Worksome\RequestFactories\RequestFactory;

class DiscountLevelRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'apply_to' => DiscountLevelApplyTo::AllProducts->value,
            'action_type' => DiscountLevelActionType::Percentage->value,
            'action_sitepricing' => null,
            'action_percentage' => $this->faker->randomFloat(2, 1, 1000),
            'status' => $this->faker->boolean,
        ];
    }
}
