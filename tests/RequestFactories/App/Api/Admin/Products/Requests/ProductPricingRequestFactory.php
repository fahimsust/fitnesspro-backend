<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Sites\Models\Site;
use Worksome\RequestFactories\RequestFactory;

class ProductPricingRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $salePrice = 0;
        $regularPrice = $this->faker->randomNumber(6);

        if($onsale = $this->faker->boolean())
            $salePrice = $regularPrice - round($regularPrice * (mt_rand(1, 15) / 100));

        return [
            'onsale'=>$onsale,
            'price_reg'=>$regularPrice,
            'price_sale'=>$salePrice,
            'min_qty'=>0,
            'max_qty'=>$this->faker->randomNumber(1),
            'feature'=>$this->faker->boolean,
            'pricing_rule_id'=>PricingRule::firstOrFactory()->id,
            'ordering_rule_id'=>OrderingRule::firstOrFactory()->id,
            'site_id'=>Site::firstOrFactory()->id,
            'status'=>$this->faker->boolean,
        ];
    }
}
