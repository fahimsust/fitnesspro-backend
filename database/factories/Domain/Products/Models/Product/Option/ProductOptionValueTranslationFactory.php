<?php

namespace Database\Factories\Domain\Products\Models\Product\Option;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValueTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOptionValueTranslationFactory extends Factory
{
    protected $model = ProductOptionValueTranslation::class;

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
            'product_option_value_id'=>ProductOptionValue::firstOrFactory(),
            'language_id'=>Language::firstOrFactory()
        ];
    }
}
