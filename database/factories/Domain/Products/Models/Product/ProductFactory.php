<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $title = $this->faker->words(5, true);

        return [
            'parent_product' => null,
            'title' => $title,
            'subtitle' => '',
            'default_outofstockstatus_id' => ProductAvailability::firstOrFactory(),
            'product_no' => '',
            'default_distributor_id' => null,
            'fulfillment_rule_id' => null,
            'url_name' => $this->faker->unique()->slug(2),
            'meta_title' => $title,
            'meta_desc' => '',
            'meta_keywords' => '',
            'inventory_id' => '',
            'customs_description' => '',
            'tariff_number' => '',
            'country_origin' => '',
            'shared_inventory_id' => null,
            'addtocart_setting' => null,
            'has_children' => false,
            'details_img_id' => null,
            'category_img_id' => null,
            'status' => true,
            'combined_stock_qty' => mt_rand(1, 100),
            'default_cost' => mt_rand(1000, 5000),
            'weight' => mt_rand(1, 100),
            'created' => $this->faker->dateTime(),
            'inventoried' => true
        ];
    }

    public function withDefaultDistributor()
    {
        return $this->state(function (array $attributes) {
            return [
                'default_distributor_id' => Distributor::firstOrFactory()
            ];
        });
    }
}
