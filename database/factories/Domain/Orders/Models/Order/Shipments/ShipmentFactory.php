<?php

namespace Database\Factories\Domain\Orders\Models\Order\Shipments;

use Domain\Distributors\Models\Distributor;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Order\Shipments\ShipmentStatus;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => function () {
                return Order::firstOrFactory()->id;
            },
            'distributor_id' => function () {
                return Distributor::firstOrFactory()->id;
            },
            'ship_method_id' => function () {
                return ShippingMethod::firstOrFactory()->id;
            },
            'order_status_id' => function () {
                return ShipmentStatus::firstOrFactory()->id;
            },
            'ship_tracking_no' => '',
            'ship_cost' => 0.00,
            'ship_date' => $this->faker->dateTime(),
            'future_ship_date' => $this->faker->dateTime(),
            'delivery_date' => $this->faker->dateTime(),
            'signed_for_by' => '',
            'is_downloads' => $this->faker->boolean,
            'last_status_update' => $this->faker->dateTime(),
            'saturday_delivery' => false,
            'alcohol' => false,
            'dangerous_goods' => false,
            'dangerous_goods_accessibility' => false,
            'hold_at_location' => false,
            'hold_at_location_address' => '',
            'signature_required' => 0,
            'cod' => false,
            'cod_amount' => 0,
            'cod_currency' => 0,
            'insured' => false,
            'insured_value' => 0,
            'archived' => false,
            'inventory_order_id' => '',
            'registry_id' => 0,
        ];
    }
}
