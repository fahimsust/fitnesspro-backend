<?php

namespace Database\Factories\Domain\Orders\Models\Order;

use Domain\AdminUsers\Models\User;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderNote;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderNoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderNote::class;

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
            'note' => $this->faker->sentence,
        ];
    }
}
