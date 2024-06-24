<?php

namespace Database\Factories\Domain\Products\Models\Category;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::firstOrFactory(),
            'language_id' => Language::firstOrFactory(),
            'subtitle' => $this->faker->title,
            'title' => $this->faker->title,
            'url_name' => $this->faker->unique()->slug(2),
            'description' => $this->faker->text
        ];
    }
}
