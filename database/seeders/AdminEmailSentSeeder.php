<?php

namespace Database\Seeders;

use Domain\AdminUsers\Models\AdminEmailsSent;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Seeder;

class AdminEmailSentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::limit(10)->orderBy('id','asc')->get();
        foreach($orders as $order)
        {
            AdminEmailsSent::factory(rand(25,35))->create(['order_id'=>$order->id]);
        }
        
    }
}
