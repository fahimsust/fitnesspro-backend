<?php

namespace Database\Factories\Domain\Orders\Models\Checkout;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Models\Checkout\CheckoutItem;
use Domain\Orders\Models\Checkout\CheckoutItemDiscount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Checkout\CheckoutItemDiscount>
 */
class CheckoutItemDiscountFactory extends Factory
{
    protected $model = CheckoutItemDiscount::class;

    public function definition(): array
    {
        $advantage = DiscountAdvantage::firstOrFactory();

        return [
            'checkout_item_id' => CheckoutItem::firstOrFactory(),
            'discount_id' => $advantage->discount_id,
            'advantage_id' => $advantage,
            'qty' => $this->faker->numberBetween(1, 10),
            'amount' => $this->faker->randomFloat(2, 1, 100) . "%",
        ];
    }
}
