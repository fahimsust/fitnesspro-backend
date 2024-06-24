<?php

namespace Database\Factories\Domain\Payments\Models;

use Domain\Payments\Models\PaymentGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentGatewayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentGateway::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'template' => $this->faker->word,
            'classname' => $this->faker->name,
        ];
    }
}
