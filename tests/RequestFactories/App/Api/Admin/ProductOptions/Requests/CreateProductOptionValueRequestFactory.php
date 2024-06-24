<?php

namespace Tests\RequestFactories\App\Api\Admin\ProductOptions\Requests;

use Domain\Products\Models\Product\Option\ProductOption;
use Worksome\RequestFactories\RequestFactory;

class CreateProductOptionValueRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'display' => $this->faker->name,
            'option_id' =>ProductOption::firstOrFactory()->id,
            'price' =>$this->faker->randomDigit,
            'rank' => $this->faker->randomDigit,
        ];
    }
}
