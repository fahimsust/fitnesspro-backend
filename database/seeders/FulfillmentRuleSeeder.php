<?php

namespace Database\Seeders;

use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Illuminate\Database\Seeder;

class FulfillmentRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FulfillmentRule::factory(10)->create();
    }
}
