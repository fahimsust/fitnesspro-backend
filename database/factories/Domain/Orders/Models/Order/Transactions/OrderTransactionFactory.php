<?php

namespace Database\Factories\Domain\Orders\Models\Order\Transactions;

use Domain\Addresses\Models\Address;
use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'order_id' => Order::firstOrFactory(),
            'transaction_no' => Str::substr($faker->uuid, 0, 20),
            'amount' => $faker->randomFloat(2, 1, 100),
            'original_amount' => $faker->randomFloat(2, 1, 100),
            'cc_no' => "",
            'cc_exp' => $faker->date,
            'notes' => "",
            'status' => OrderTransactionStatuses::Authorized,
            'billing_address_id' => Address::firstOrFactory(),
            'payment_method_id' => PaymentMethod::firstOrFactory(),
            'gateway_account_id' => PaymentAccount::firstOrFactory(),
            'capture_on_shipment' => 0,
            'created_at' => now(),
        ];
    }
}
