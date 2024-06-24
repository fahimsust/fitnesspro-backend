<?php

namespace Database\Factories\Domain\Discounts\Models\Advantage;

use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\AdvantageProductType;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvantageProductTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdvantageProductType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'advantage_id' => DiscountAdvantage::firstOrFactory(),
            'producttype_id' => ProductType::firstOrFactory(),
            'applyto_qty' => mt_rand(1, 5),
        ];
    }
}
