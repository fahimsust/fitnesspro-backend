<?php

namespace Database\Factories\Domain\Trips\Models;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Photos\Models\Photo;
use Domain\Trips\Models\TripFlyer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFlyerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TripFlyer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'orders_products_id' => OrderItem::factory(),
            'position' => $this->faker->jobTitle,
//            'logo' => $this->faker->imageUrl(640, 480, 'cats', true, 'Faker'),
            'bio' => $this->faker->realText(84, 2),
            'name' => $this->faker->name,
            'approval_status' => $this->faker->numberBetween(0, 1),
            'created' => $this->faker->dateTime(),
            'photo_id' => Photo::factory(),
        ];
    }
}
