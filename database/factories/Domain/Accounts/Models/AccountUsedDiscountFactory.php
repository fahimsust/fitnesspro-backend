<?php

namespace Database\Factories\Domain\Accounts\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountUsedDiscount;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountUsedDiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountUsedDiscount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::firstOrFactory(),
            'discount_id' => Discount::firstOrFactory(),
            'order_id' => Order::firstOrFactory(),
            'times_used' => mt_rand(1, 10),
            'used' => now()
        ];
    }
}
