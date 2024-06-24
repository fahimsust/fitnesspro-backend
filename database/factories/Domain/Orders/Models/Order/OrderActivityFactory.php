<?php

namespace Database\Factories\Domain\Orders\Models\Order;

use Domain\AdminUsers\Models\User;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::firstOrFactory(),
            'user_id' => User::firstOrFactory(),
            'description' => $this->faker->sentence,
        ];
    }
}
