<?php

namespace Database\Seeders;

use Domain\Orders\Models\Shipping\ShippingCarrier;
use Illuminate\Database\Seeder;

class ShippingCarrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,1,'FedEx','FedEx','fedex',1,1,'',0],
            [2,2,'UPS','UPS','ups',1,1,'',0],
//            [3,3,'USPS','USPS','usps',1,0,'',0],
//            [4,4,'StarTrack (Australia)','StarTrack','startrack',0,1,'',0],
            [5,5,'Generic Shipping','GenericShipping','genericshipping',1,1,'',0],
            [6,6,'USPS via Endicia','Endicia','endicia',1,0,'',0],
//            [7,7,'Canada Post','CanadaPost','canadapost',1,0,'',0],
//            [8,8,'Endicia via ShipStation','','',0,1,'endicia',0],
//            [9,9,'USPS via ShipStation','','',0,1,'express_1',0],
//            [26,9,'PostaPlus','','',1,1,'',0]
        ];

        $fields = ['id','gateway_id','name','classname','table','status','multipackage_support','carrier_code','limit_shipto'];

        foreach ($rows as $row) {
            ShippingCarrier::create(array_combine($fields, $row));
        }
    }
}
