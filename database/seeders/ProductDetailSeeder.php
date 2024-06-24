<?php

namespace Database\Seeders;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Seeder;

class ProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        if ($products)
            foreach ($products as $value) {
                ProductDetail::factory()->create(['product_id' => $value->id]);
            }
    }
}
