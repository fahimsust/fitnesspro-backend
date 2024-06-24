<?php

namespace Database\Factories\Domain\Products\Models\Category;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategorySettings;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorySettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategorySettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::firstOrFactory(),
        ];
    }
}
