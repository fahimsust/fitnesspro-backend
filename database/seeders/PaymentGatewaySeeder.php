<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Domain\Payments\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Authorize.net AIM','gateway_aim',1,'AuthnetConnect'],
            [2,'Authorize.net CIM','gateway_cim',1,'AuthnetCIMConnect'],
            [3,'CommWeb VPC','gateway_commwebvpc',1,'CommWebVPC'],
            [4,'PayPal Payments Pro (Express Checkout)','gateway_paypalproexpress',2,'PaypalProExpress'],
            [5,'PayPal Payments Pro (Direct Payment)','gateway_paypalprodirect',1,'PaypalProDirect'],
            [6,'USA Epay','gateway_usaepay',1,'UsaEpay'],
            [7,'Cayan','gateway_aim',1,'Cayan'],
            [8,'Moneris','gateway_aim',1,'Moneris'],
            [10,'PayTabs','gateway_paytabs',2,'PayTabs'],
            [11,'Alipay Cross Border Website','gateway_alipay',2,'AlipayCrossBorderWeb']
        ];
        $fields = ['id','name','template','is_creditcard','classname'];

        foreach ($rows as $row) {
            PaymentGateway::create(array_combine($fields, $row));
        }
    }
}
