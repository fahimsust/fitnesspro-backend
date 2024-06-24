<?php

namespace Database\Factories\Domain\Accounts\Models\Cim;

use Domain\Accounts\Models\Cim\CimProfile;
use Domain\Payments\Models\PaymentAccount;
use Illuminate\Database\Eloquent\Factories\Factory;
use function now;

class CimProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CimProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'authnet_profile_id' => mt_rand(100000, 9999999),
            'gateway_account_id' => PaymentAccount::firstOrFactory()
        ];
    }
}
