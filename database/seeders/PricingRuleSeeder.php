<?php

namespace Database\Seeders;

use Domain\Products\Models\Product\Pricing\PricingRule;
use Illuminate\Database\Seeder;

class PricingRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PricingRule::factory(10)->create();
    }
}
