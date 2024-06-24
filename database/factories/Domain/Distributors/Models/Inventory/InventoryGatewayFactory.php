<?php

namespace Database\Factories\Domain\Distributors\Models\Inventory;

use Domain\Distributors\Models\Inventory\InventoryGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryGatewayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InventoryGateway::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'class_name' => $this->faker->domainWord,
            'status' => true,
            'price_fields' => '',
            'loadproductsby' => 0,
        ];
    }
}
