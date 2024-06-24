<?php

namespace Database\Factories\Domain\Products\Models\Category;

use Domain\Products\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Support\Enums\MatchAllAnyString;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->words(4, true);
        $description = $this->faker->paragraph;

        return [
            'parent_id' => null,
            'title' => $title,
            'subtitle' => $this->faker->words(3, true),
            'description' => $description,
            'image_id' => 0,
            'rank' => $this->faker->randomDigit,
            'status' => true,
            'url_name' => $this->faker->unique()->slug(2),
            'show_sale' => false,
            'limit_min_price' => 0,
            'min_price' => 0,
            'limit_max_price' => 0,
            'max_price' => 0,
            'show_in_list' => true,
            'limit_days' => 0,
            'meta_title' => $title,
            'meta_desc' => Str::substr($description, 0, 255),
            'meta_keywords' => $this->faker->words(3, true),
            'show_types' => true,
            'show_brands' => true,
            'rules_match_type' => MatchAllAnyString::ANY,
            'inventory_id' => $this->faker->randomNumber(5),
            'menu_class' => '',
        ];
    }
}
