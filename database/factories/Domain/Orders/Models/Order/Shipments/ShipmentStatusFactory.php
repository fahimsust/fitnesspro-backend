<?php

namespace Database\Factories\Domain\Orders\Models\Order\Shipments;

use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShipmentStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'rank' => $this->faker->randomDigit,
        ];
    }
}
