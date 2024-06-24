<?php

namespace Database\Seeders;

use Domain\Discounts\Enums\DiscountAdvantageTypes;
use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discounts = Discount::factory(10)->create();
        $product_ids = Product::all()->pluck('id');
        foreach ($discounts as $value) {
            $rule = DiscountRule::factory()->create(['discount_id' => $value->id]);
            DiscountCondition::factory()->create(['rule_id' => $rule->id]);
            DiscountAdvantage::factory()->create(['discount_id' => $value->id]);
            DiscountAdvantage::factory()->create(['amount' => 10, 'discount_id' => $value->id, 'advantage_type_id' => DiscountAdvantageTypes::AMOUNT_OFF_ORDER]);
            $advantage = DiscountAdvantage::factory()->create(['amount' => 10, 'discount_id' => $value->id, 'advantage_type_id' => DiscountAdvantageTypes::AMOUNT_OFF_PRODUCT]);
            foreach ($product_ids as $product_id) {
                AdvantageProduct::factory()->create(['product_id' => $product_id, 'advantage_id' => $advantage->id]);
            }
        }
    }
}
