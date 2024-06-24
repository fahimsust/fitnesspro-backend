<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Worksome\RequestFactories\RequestFactory;
use Illuminate\Support\Str;

class ProductCustomsInfoRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'customs_description' => $this->faker->title,
            'tariff_number' => Str::random(rand(4,54)),
            'country_origin' => Str::random(rand(2,19)),
        ];
    }
}
