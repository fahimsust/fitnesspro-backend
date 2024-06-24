<?php

namespace Tests\RequestFactories\App\Api\Admin\Orders\Requests;

use Domain\Payments\Models\PaymentAccount;
use Worksome\RequestFactories\RequestFactory;

class CreateOrderTransactionsRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $faker = $this->faker;
        $chargeType = $faker->randomElement(['1', '2']);

        return [
            'charge_type' => $chargeType,
            'cc_number' => $chargeType == '1' ? $faker->creditCardNumber : null,
            'cc_exp_year' => $chargeType == '1' ? '2030' : null,
            'cc_exp_month' => $chargeType == '1' ? "02" : null,
            'charge_cvv' => $chargeType == '1' ? '768' : null,
            'note' => $faker->optional()->text,
            'check_number' => $chargeType == '2' ? $faker->word : null,
            'amount' => $faker->randomFloat(2, 1, 1000),
            'gateway_account_id' => PaymentAccount::firstOrFactory()->id
        ];
    }
}
