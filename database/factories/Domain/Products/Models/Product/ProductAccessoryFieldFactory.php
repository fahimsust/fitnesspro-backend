<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessoryField;
use Domain\Products\Models\Product\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAccessoryFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductAccessoryField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::firstOrFactory(),
            'accessories_fields_id' => AccessoryField::firstOrFactory(),
            'rank' => mt_rand(1, 99)
        ];
    }
}
