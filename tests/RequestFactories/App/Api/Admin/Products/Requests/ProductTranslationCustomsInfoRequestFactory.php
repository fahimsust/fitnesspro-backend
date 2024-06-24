<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Worksome\RequestFactories\RequestFactory;
use Illuminate\Support\Str;

class ProductTranslationCustomsInfoRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'customs_description' => $this->faker->title,
        ];
    }
}
