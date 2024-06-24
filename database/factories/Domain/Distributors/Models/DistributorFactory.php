<?php

namespace Database\Factories\Domain\Distributors\Models;

use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\Inventory\InventoryAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistributorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Distributor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'active' => true,
            'email' => $this->faker->email,
            'phone' => str_replace(' ', '', $this->faker->phoneNumber),
            'account_no' => $this->faker->randomNumber(8),
            'is_dropshipper' => $this->faker->boolean,
            'inventory_account_id' => null,
        ];
    }
}
