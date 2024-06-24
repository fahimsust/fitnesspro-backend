<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPricingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductPricing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $salePrice = 0;
        $regularPrice = $this->faker->randomFloat(2,2,200);

        if($onsale = $this->faker->boolean())
            $salePrice = $regularPrice - ($regularPrice * (mt_rand(1, 15) / 100));

        return [
            'product_id' => Product::firstOrFactory(),
            'site_id' => Site::firstOrFactory(),
            'price_reg' => fn() => $regularPrice,
            'price_sale' => fn() => $salePrice,
            'onsale' => fn() => $onsale,
            'max_qty'=>rand(4,10),
            'status' => true,
            'feature' => false,
        ];
    }
}
