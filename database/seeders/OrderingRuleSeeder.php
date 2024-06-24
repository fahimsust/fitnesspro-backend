<?php

namespace Database\Seeders;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Illuminate\Database\Seeder;

class OrderingRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderingRule::factory(10)->create();
    }
}
