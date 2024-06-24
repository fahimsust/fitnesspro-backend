<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Distributors\Models\Inventory\InventoryGateway;

class InventoryGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Lightspeed','lightspeedConnect',0,0,''],
            [2,'Lightspeed Webstore','lightspeedWSConnect',0,0,'{\"sell\":\"Sell Price\", \"sell_web\":\"Web Price\", \"sell_tax_inclusive\":\"Sell Tax Incl. Price\", \"web_keyword1\":\"Web Keyword 1\", \"web_keyword2\":\"Web Keyword 2\", \"web_keyword3\":\"Web Keyword 3\", \"class_name\":\"Class\"}'],
            [3,'Lightspeed Webstore 3.0','lightspeedWS3Connect',0,0,'{\"sell\":\"Sell Price\", \"sell_web\":\"Web Price\", \"sell_tax_inclusive\":\"Sell Tax Incl. Price\", \"class_name\":\"Class\"}'],
            [4,'Lightspeed Cloud','lightspeedCloudConnect',1,1,'{\"Default\":\"Price\", \"MSRP\":\"MSRP\", \"-\":\"None\"}'],
            [5,'Lightspeed WS3 v3','lightspeedWS3Connectv3',1,1,'{\"sell\":\"Sell Price\", \"sell_web\":\"Web Price\", \"sell_tax_inclusive\":\"Sell Tax Incl. Price\", \"class_name\":\"Class\"}'],
            [7,'Panache','Panache',1,0,'']
        ];
        $fields = ['id','name','class_name','status','loadproductsby','price_fields'];

        foreach ($rows as $row) {
            InventoryGateway::create(array_combine($fields, $row));
        }
    }
}
