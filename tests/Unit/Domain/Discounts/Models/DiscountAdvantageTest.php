<?php

namespace Tests\Unit\Domain\Discounts\Models;

use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountUsedDiscount;
use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\AdvantageProductType;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class DiscountAdvantageTest extends TestCase
{
    protected Model|DiscountAdvantage $advantage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->advantage = DiscountAdvantage::factory()->create();
    }

    /** @test */
    public function can_get_discount()
    {
        $this->assertInstanceOf(Discount::class, $this->advantage->discount);
    }

    /** @test */
    public function can_get_products()
    {
        AdvantageProduct::factory(3)->create([
            'product_id' => Product::factory()
        ]);

        $products = $this->advantage->targetProducts()->get();

        $this->assertCount(3, $products);
        $this->assertInstanceOf(Product::class, $products->first());
        $this->assertIsNumeric($products->first()->pivot->applyto_qty);
    }

    /** @test */
    public function can_get_product_types()
    {
        AdvantageProductType::factory(3)->create([
            'producttype_id' => ProductType::factory()
        ]);

        $types = $this->advantage->targetProductTypes()->get();

        $this->assertCount(3, $types);
        $this->assertInstanceOf(ProductType::class, $types->first());
        $this->assertIsNumeric($types->first()->pivot->applyto_qty);
    }
}
