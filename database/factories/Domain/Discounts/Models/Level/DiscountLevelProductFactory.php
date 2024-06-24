<?php
namespace Database\Factories\Domain\Discounts\Models\Level;

use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountLevelProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiscountLevelProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'discount_level_id' => DiscountLevel::firstOrFactory(),
            'product_id' => Product::firstOrFactory()
        ];
    }
}
