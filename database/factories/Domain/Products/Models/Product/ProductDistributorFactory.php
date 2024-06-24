<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\ProductType;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class ProductDistributorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductDistributor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::firstOrFactory(),
            'distributor_id' => Distributor::firstOrFactory(),
            'outofstockstatus_id' => ProductAvailability::firstOrFactory(),
            'stock_qty' => mt_rand(1, 55),
            'cost' => mt_rand(100, 6600),
            'inventory_id' => $this->faker->word,
        ];
    }
}
