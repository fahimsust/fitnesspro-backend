<?php

namespace Database\Seeders;

use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Illuminate\Database\Seeder;
use Domain\Payments\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [1,'Authorize.net CIM','Pay by Credit Card',2,1,NULL,0,0],
            [2,'Pay by Phone','Pay by Phone',null,1,'payment_phone',0,0],
            [3,'Cash on Delivery (COD)','Cash on Delivery (COD)',null,1,'payment_cod',0,0],
            [4,'Net 30 (Credit Terms)','Net 30 (Credit Terms)',null,1,'payment_creditterms',0,0],
            [5,'Authorize.net AIM','Pay by Credit Card',1,1,NULL,0,0],
            [6,'CommWeb VPC','Pay By Credit Card',3,0,NULL,0,0],
            [7,'PayPal Payments Pro (Express Checkout)','Pay by PayPal',4,1,NULL,0,0],
            [8,'PayPal Payments Pro (Direct Payment)','Pay by Credit Card',5,0,NULL,0,0]
        ];
        $fields = ['id','name','display','gateway_id','status','template','limitby_country','feeby_country'];

        foreach ($rows as $row) {
            $paymentMethod = PaymentMethod::create(array_combine($fields, $row));
            SubscriptionPaymentOption::factory()->create(['payment_method_id'=>$paymentMethod->id]);
        }
    }
}
