<?php

namespace Tests\RequestFactories\App\Api\Admin\Categories\Requests;

use Worksome\RequestFactories\RequestFactory;

class CategoryMenuSettingsRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'rank' => $this->faker->randomDigit,
            'show_in_list' => $this->faker->boolean,
            'menu_class' => $this->faker->word,
        ];
    }
}
