<?php

namespace Tests\Feature\Traits;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Illuminate\Support\Collection;

trait TestProductUtilities
{
    protected Product $product;
    protected Collection $productOptions;
    protected Collection $productPricing;

    protected function createProductWithOptionValues()
    {
        $this->product = Product::factory()->create(['parent_product' => null]);
        ProductDetail::factory()
            ->for($this->product)
            ->create();

        $this->productPricing = ProductPricing::factory(3)
            ->for($this->product)
            ->sequence(
                ['site_id' => null],
                ['site_id' => Site::factory()->create()],
                ['site_id' => Site::factory()->create()],
            )
            ->create();

        $this->productOptions = ProductOption::factory(2)
            ->for($this->product)
            ->create([
                'required' => 1,
            ])
            ->each(
                fn(ProductOption $option) => ProductOptionValue::factory(2)
                    ->for($option, 'option')
                    ->create()
            );
    }
}
