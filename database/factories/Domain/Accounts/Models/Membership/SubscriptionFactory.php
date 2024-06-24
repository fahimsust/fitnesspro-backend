<?php

namespace Database\Factories\Domain\Accounts\Models\Membership;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Orders\Models\Order\Order;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = Carbon::now();
        $start_date = new Carbon('1 year ago');
        $end_date = Carbon::tomorrow();

        return [
            'level_id' => MembershipLevel::firstOrFactory(),
            'amount_paid' => '50000.04',
            'start_date' => $start_date->toDateTimeString(),
            'end_date' => $end_date->toDateTimeString(),
            'account_id' => Account::firstOrFactory(),
            'order_id' => Order::firstOrFactory(),
            'subscription_price' => '100.06',
            'product_id' => Product::firstOrFactory(),
            'created' => $date,
            'expirealert1_sent' => 0,
            'expirealert2_sent' => 0,
            'expire_sent' => 0,
        ];
    }
}
