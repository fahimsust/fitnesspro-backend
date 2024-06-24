<?php

namespace Database\Seeders;

use Domain\Orders\Models\Shipping\ShippingGateway;
use Illuminate\Database\Seeder;

class ShippingGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1, 'FedEx', 'FedEx', 'fedex', 1, 1],
            [2, 'UPS', 'UPS', 'ups', 1, 1],
//            [3, 'USPS', 'USPS', 'usps', 1, 0],
//            [4, 'StarTrack (Australia)', 'StarTrack', 'startrack', 0, 1],
            [5, 'Generic Shipping', 'GenericShipping', 'genericshipping', 1, 1],
            [6, 'USPS via Endicia', 'Endicia', 'endicia', 1, 0],
//            [7, 'Canada Post', 'CanadaPost', 'canadapost', 1, 0],
//            [8, 'ShipStation', 'ShipStation', 'shipstation', 1, 0],
//            [9, 'PostaPlus', 'Postaplus', 'postaplus', 1, 0],
        ];
        $fields = ['id', 'name', 'classname', 'table', 'status', 'multipackage_support'];

        foreach ($rows as $row) {
            ShippingGateway::create(array_combine($fields, $row));
        }
    }
}
