<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Worksome\RequestFactories\RequestFactory;

class ProductAddToCartSettingsRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'addtocart_external_label' => $this->faker->title,
            'addtocart_external_label' => $this->faker->word,
            'addtocart_setting'=>$this->faker->randomElement(['0','1','2'])
        ];
    }
}
