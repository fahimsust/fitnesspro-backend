<?php

namespace Database\Factories\Domain\Discounts\Models\Advantage;

use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Distributors\Models\Distributor;
use Domain\Locales\Models\Country;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountAdvantageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiscountAdvantage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'discount_id' => Discount::firstOrFactory(),
            'advantage_type_id' => $this->faker->randomElement(DiscountAdvantageTypes::cases()),//AdvantageType::firstOrFactory(),
            'amount' => $this->faker->randomFloat(2, 3, 50),
            'apply_shipping_country' => Country::firstOrFactory(),
            'apply_shipping_distributor' => Distributor::firstOrFactory(),
            'apply_shipping_id'=>ShippingMethod::firstOrFactory(),
            'applyto_qty_type' => 0,
            'applyto_qty_combined' => 0
        ];
    }
}
