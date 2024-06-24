<?php

namespace Database\Factories\Domain\Affiliates\Models;

use Domain\Affiliates\Enums\ReferralType;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Domain\Affiliates\Models\ReferralStatus;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Affiliates\Models\Affiliate>
 */
class ReferralFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Referral::class;

    public function definition()
    {
        return [
            'affiliate_id' => Affiliate::firstOrFactory(),
            'order_id' => Order::firstOrFactory(),
            'status_id' => ReferralStatus::firstOrFactory(),
            'type_id' => ReferralType::ORDER->value,
            'amount' => $this->faker->randomNumber(),
        ];
    }
}
