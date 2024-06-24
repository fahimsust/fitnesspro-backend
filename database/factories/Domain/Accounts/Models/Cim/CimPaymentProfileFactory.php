<?php

namespace Database\Factories\Domain\Accounts\Models\Cim;

use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Accounts\Models\Cim\CimProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use function now;

class CimPaymentProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CimPaymentProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'profile_id' => CimProfile::firstOrFactory(),
            'first_cc_number' => mt_rand(1, 9),
            'cc_number' => mt_rand(1000, 9999),
            'cc_exp' => now()->format("Y-m-d"),
            'zipcode' => mt_rand(10000, 99999),
            'authnet_payment_profile_id' => mt_rand(100000, 9999999),
            'is_default' => true
        ];
    }
}
