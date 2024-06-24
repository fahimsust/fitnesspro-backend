<?php

namespace Database\Factories\Domain\Discounts\Models\Rule\Condition;

use Domain\Discounts\Models\Rule\Condition\ConditionProduct;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConditionProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condition_id' => DiscountCondition::firstOrFactory(),
            'product_id' => Product::firstOrFactory()
        ];
    }
}
