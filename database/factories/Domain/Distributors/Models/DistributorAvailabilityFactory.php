<?php

namespace Database\Factories\Domain\Distributors\Models;

use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\DistributorAvailability;
use Domain\Distributors\Models\Inventory\InventoryAccount;
use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistributorAvailabilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DistributorAvailability::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'distributor_id' => Distributor::firstOrFactory(),
            'availability_id' => ProductAvailability::firstOrFactory(),
            'display' => $this->faker->word,
        ];
    }
}
