<?php

namespace Database\Seeders;

use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Products\Models\Product\Pricing\PricingRuleLevel;
use Illuminate\Database\Seeder;

class PricingRuleLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pricingRule = PricingRule::all();
        if($pricingRule)
        foreach($pricingRule as $value)
        {
            PricingRuleLevel::factory()->create(['rule_id'=>$value->id]);
        }
    }
}
