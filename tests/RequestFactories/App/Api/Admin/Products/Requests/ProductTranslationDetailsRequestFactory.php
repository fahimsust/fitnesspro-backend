<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Worksome\RequestFactories\RequestFactory;

class ProductTranslationDetailsRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'summary'=>$this->faker->text,
            'description'=>$this->faker->text,
        ];
    }
}
