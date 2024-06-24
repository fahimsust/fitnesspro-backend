<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSettingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductSettings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::firstOrFactory(),
            'module_custom_values' => '',
            'module_override_values' => ''
        ];
    }
}
