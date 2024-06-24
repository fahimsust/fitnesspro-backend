<?php

namespace Tests\RequestFactories\App\Api\Admin\ProductOptions\Requests;

use Domain\Products\Models\Product\Option\ProductOptionValue;
use Worksome\RequestFactories\RequestFactory;

class CustomFieldOptionValueRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'custom_type' => $this->faker->randomDigit,
            'custom_charlimit' => $this->faker->randomDigit,
            'custom_label' => $this->faker->name,
            'custom_instruction' => $this->faker->name,
        ];
    }
}
