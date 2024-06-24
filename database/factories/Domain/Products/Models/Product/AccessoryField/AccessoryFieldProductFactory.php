<?php

namespace Database\Factories\Domain\Products\Models\Product\AccessoryField;

use Domain\Products\Enums\PriceAdjustTargets;
use Domain\Products\Enums\PriceAdjustTypes;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\AccessoryField\AccessoryFieldProduct;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessoryFieldProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccessoryFieldProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'accessories_fields_id' => AccessoryField::firstOrFactory(),
            'product_id' => Product::firstOrFactory(),
            'label' => $this->faker->word,
            'rank' => 0,
            'price_adjust_type' => $this->faker->randomElement(
                PriceAdjustTargets::cases()
            ),
            'price_adjust_calc' => $this->faker->randomElement(
                PriceAdjustTypes::cases()
            ),
            'price_adjust_amount' => $this->faker->randomNumber(3)
        ];
    }
}
