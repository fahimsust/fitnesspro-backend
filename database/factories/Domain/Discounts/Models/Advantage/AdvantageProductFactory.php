<?php

namespace Database\Factories\Domain\Discounts\Models\Advantage;

use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvantageProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdvantageProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'advantage_id' => DiscountAdvantage::firstOrFactory(),
            'product_id' => Product::firstOrFactory(),
            'applyto_qty' => mt_rand(1, 5),
        ];
    }
}
