<?php

namespace Tests\Feature\Traits;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDistributor;
use Illuminate\Database\Eloquent\Collection;

trait TestProductVariantInventory
{
    protected Product $product;
    protected Collection $products;
    protected Collection $distributors;

    protected function createProductVariantInventory()
    {
        $this->product = Product::factory()->create(['combined_stock_qty' => 20]);
        $this->distributors = Distributor::factory(2)->create();
        $this->products = Product::factory(5)->create(
            [
                'combined_stock_qty' => 4,
                'parent_product' => $this->product->id
            ]
        );
        foreach ($this->products as $product) {
            foreach ($this->distributors as $distributor) {
                ProductDistributor::factory()->create(
                    [
                        'product_id' => $product->id,
                        'distributor_id' => $distributor->id,
                        'stock_qty' => 2,
                    ]
                );
            }
        }
    }
}
