<?php

namespace Tests\RequestFactories\App\Api\Admin\Categories\Requests;

use Support\Enums\MatchAllAnyString;
use Worksome\RequestFactories\RequestFactory;

class CategoryFilterSettingsRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'show_sale' => $this->faker->boolean,
            'limit_min_price' => $this->faker->boolean,
            'min_price' => $this->faker->randomDigit,
            'limit_max_price' => $this->faker->boolean,
            'max_price' => $this->faker->randomDigit,
            'show_in_list' => $this->faker->boolean,
            'limit_days' => $this->faker->randomDigit,
            'show_types' => $this->faker->boolean,
            'show_brands' => $this->faker->boolean,
            'rules_match_type' => $this->faker->randomElement(MatchAllAnyString::cases())->value,
        ];
    }
}
