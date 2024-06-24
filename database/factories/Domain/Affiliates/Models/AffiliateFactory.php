<?php

namespace Database\Factories\Domain\Affiliates\Models;

use Domain\Accounts\Models\Account;
use Domain\Addresses\Models\Address;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\AffiliateLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain\Affiliates\Models\Affiliate>
 */
class AffiliateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Affiliate::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'address_id' => Address::firstOrFactory(),
            'status' => 1,
            'affiliate_level_id' => AffiliateLevel::firstOrFactory(),
            'account_id' => Null, //$account->id,
        ];
    }
}
