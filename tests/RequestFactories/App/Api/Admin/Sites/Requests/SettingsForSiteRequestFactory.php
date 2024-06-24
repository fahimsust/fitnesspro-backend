<?php

namespace Tests\RequestFactories\App\Api\Admin\Sites\Requests;

use Worksome\RequestFactories\RequestFactory;

class SettingsForSiteRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'home_show_categories_in_body'=>$this->faker->boolean,
            'home_feature_show'=>$this->faker->boolean,
            'catalog_show_categories_in_body'=>$this->faker->boolean,
            'catalog_feature_show'=>$this->faker->boolean,
            'default_show_categories_in_body'=>$this->faker->boolean,
        ];
    }
}
