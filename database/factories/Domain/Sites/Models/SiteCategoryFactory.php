<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Products\Models\Category\Category;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::firstOrFactory(),
            'site_id' => Site::firstOrFactory()
        ];
    }
}
