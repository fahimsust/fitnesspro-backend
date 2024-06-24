<?php

namespace Database\Factories\Domain\Accounts\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'account_id' => Account::firstOrFactory(),
            'is_billing' => $faker->boolean(),
            'is_shipping' => $faker->boolean(),

            'address_id' => Address::firstOrFactory(),
            'status' => $faker->boolean(),
        ];
    }
}
