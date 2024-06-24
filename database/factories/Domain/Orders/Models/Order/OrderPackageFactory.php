<?php

namespace Database\Factories\Domain\Orders\Models\Order;

use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderPackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderPackage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shipment_id' => function () {
                return Shipment::firstOrFactory()->id;
            },
            'package_type' => 0,
            'package_size' => 0,
            'is_dryice' => false,
            'dryice_weight' => 0.0,
        ];
    }
}
