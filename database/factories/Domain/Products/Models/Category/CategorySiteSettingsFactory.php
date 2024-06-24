<?php

namespace Database\Factories\Domain\Products\Models\Category;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorySiteSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategorySiteSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::firstOrFactory(),
            'site_id' => Site::firstOrFactory(),
        ];
    }
}
