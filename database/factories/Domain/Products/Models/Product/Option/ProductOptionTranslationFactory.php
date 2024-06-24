<?php

namespace Database\Factories\Domain\Products\Models\Product\Option;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOptionTranslationFactory extends Factory
{
    protected $model = ProductOptionTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(5, true);
        return [
            'name' => $name,
            'display' => $name,
            'product_option_id'=>ProductOption::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
