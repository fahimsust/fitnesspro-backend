<?php

namespace Database\Factories\Domain\AdminUsers\Models;

use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\AdminUsers\Models\AdminEmailsSent;
use Domain\AdminUsers\Models\User;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminEmailsSentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdminEmailsSent::class;

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
            'sent_to' => $faker->email,
            'subject' => $faker->word,
            'template_id' => MessageTemplate::firstOrFactory(),
            'content' => $faker->sentence,
            'sent_date' => Carbon::now(),
            'sent_by' => User::firstOrFactory(),
            'order_id' => Order::firstOrFactory(),
        ];
    }
}
