<?php

namespace Database\Seeders;

use Domain\Accounts\Models\AccountAddress;
use Domain\Addresses\Models\Address;
use Domain\Affiliates\Enums\ReferralType;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Domain\Affiliates\Models\ReferralStatus;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Seeder;

class ReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $affiliates = Affiliate::all();
        if ($affiliates) {
            foreach ($affiliates as $value) {
                $address = Address::factory(2)->create();
                AccountAddress::factory()->create(['account_id' => $value->account_id, 'address_id' => $address[0]->id]);
                AccountAddress::factory()->create(['account_id' => $value->account_id, 'address_id' => $address[1]->id]);
                Referral::factory(rand(8, 20))
                    ->create(
                        [
                            'order_id' => Order::factory(
                                [
                                    'billing_address_id' => $address[0]->id,
                                    'shipping_address_id' => $address[1]->id,
                                    'account_id' => $value->account_id
                                ]
                            )->create()->id,
                            'status_id' => ReferralStatus::inRandomOrder()->first()->id,
                            'type_id' => collect(ReferralType::cases())
                                ->random()->value,
                            'affiliate_id' => $value->id
                        ]
                    );
            }
        }
    }
}
