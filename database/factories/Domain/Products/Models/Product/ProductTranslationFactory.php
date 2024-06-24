<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductTranslationFactory extends Factory
{
    protected $model = ProductTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->words(5, true);
        return [
            'title' => $title,
            'url_name' => $this->faker->unique()->slug(2),
            'meta_title' => $title,
            'product_id'=>Product::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
