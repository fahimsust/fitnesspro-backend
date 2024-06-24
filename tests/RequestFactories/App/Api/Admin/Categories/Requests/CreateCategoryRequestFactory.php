<?php

namespace Tests\RequestFactories\App\Api\Admin\Categories\Requests;

use Domain\Products\Models\Category\Category;
use Worksome\RequestFactories\RequestFactory;

class CreateCategoryRequestFactory extends RequestFactory
{
    public function definition(): array
    {

        return [
            'subtitle' => $this->faker->title,
            'title' => $this->faker->title,
            'url_name' => $this->faker->unique()->slug(2),
            'description' => $this->faker->text,
            'parent_id'=>Category::firstOrFactory()->id,
        ];
    }
}
