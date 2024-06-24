<?php

namespace Database\Factories\Domain\Accounts\Models\Membership;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Affiliates\Models\AffiliateLevel;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipLevelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MembershipLevel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'rank' => 0,
            'status' => true,
            'annual_product_id' => Product::firstOrFactory([
                'inventoried' => false
            ]),
            'monthly_product_id' => null,
            'renewal_discount' => 0,
            'description' => $this->faker->sentence,
            'signupemail_customer'=> 0,
            'renewemail_customer' => 0,
            'expirationalert1_email' => 0,
            'expirationalert2_email' => 0,
            'expiration_email' => 0,
            'affiliate_level_id' => AffiliateLevel::firstOrFactory(),
            'is_default' => (int) $this->faker->boolean(),
        ];
    }
}
