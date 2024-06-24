<?php

namespace Database\Factories\Domain\Payments\Models;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'login_id' => $this->faker->userName,
            'password'=>$this->faker->password(),
            'gateway_id' => PaymentGateway::firstOrFactory(),
            'transaction_key' => $this->faker->uuid,
            'use_cvv' => 0,
            'currency_code' => "USD",
            'use_test'=>1,
            'custom_fields'=>'[]',
            'limitby_country'=>0
        ];
    }
}
