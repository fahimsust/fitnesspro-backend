<?php

namespace Database\Factories\Domain\Distributors\Models\Inventory;

use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\Inventory\InventoryAccount;
use Domain\Distributors\Models\Inventory\InventoryGateway;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class InventoryAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InventoryAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = Date::now()->format('Y-m-d');

        return [
            'gateway_id' => InventoryGateway::firstOrFactory(),
            'name' => $this->faker->words(2, true),
            'user' => '',
            'password' => '',
            'url' => '',
            'transkey' => '',
            'custom_fields' => '',
            'status' => true,
            'last_load' => $date,
            'last_load_id' => 0,
            'last_update' => $date,
            'frequency_load' => 0,
            'frequency_update' => 0,
            'last_price_sync' => $date,
            'last_matrix_price_sync' => $date,
            'update_pricing' => true,
            'update_status' => true,
            'update_cost' => true,
            'update_weight' => true,
            'create_children' => true,
            'regular_price_field' => '',
            'sale_price_field' => '',
            'onsale_formula' => 1,
            'use_taxinclusive_pricing' => false,
            'refresh_token' => '',
            'use_parent_inventory_id' => false,
            'distributor_id' => Distributor::firstOrFactory(),
            'base_currency' => 1,
        ];
    }
}
