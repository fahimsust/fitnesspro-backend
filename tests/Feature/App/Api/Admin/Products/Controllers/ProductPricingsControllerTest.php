<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductPricingsControllerTest extends ControllerTestCase
{
    public Product $product;
    public Product $childProduct1;
    public Product $childProduct2;
    private Site $site;
    private Site $site2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->product = Product::factory()->create();
        $this->site = Site::factory()->create(['id' => config('site.id')]);
        $this->site2 = Site::factory()->create();
        $this->childProduct1 = Product::factory()->create(['parent_product'=>$this->product->id,'title'=>'test']);
        $this->childProduct2 = Product::factory()->create(['parent_product'=>$this->product->id,'title'=>'not_match']);
        ProductPricing::factory()->create(['product_id' => $this->childProduct1->id,'site_id'=> $this->site->id]);
        ProductPricing::factory()->create(['product_id' => $this->childProduct1->id,'site_id'=> $this->site2->id]);
        ProductPricing::factory()->create(['product_id' => $this->childProduct1->id,'site_id'=>NULL]);
        ProductPricing::factory()->create(['product_id' => $this->childProduct2->id,'site_id'=> $this->site->id]);
        ProductPricing::factory()->create(['product_id' => $this->childProduct2->id,'site_id'=> $this->site2->id]);
        ProductPricing::factory()->create(['product_id' => $this->childProduct2->id,'site_id'=>NULL]);
    }

    /** @test */
    public function can_get_child_product_pricings()
    {
        $this->getJson(route('admin.product.pricings',[$this->product]))
            ->assertOk()
            ->assertJsonStructure(['data'=>["*" => ['id', 'price_reg', 'price_sale']]])
            ->assertJsonCount(6,'data');
    }
    /** @test */
    public function can_search_child_product_pricings()
    {
        $this->getJson(route('admin.product.pricings',[$this->product,'keyword'=>'test']))
            ->assertOk()
            ->assertJsonStructure(['data'=>["*" => ['id', 'price_reg', 'price_sale']]])
            ->assertJsonCount(3,'data');
    }
    /** @test */
    public function can_search_child_product_pricings_by_site_id()
    {
        $this->getJson(route('admin.product.pricings',[$this->product,'site_id'=>$this->site->id]))
            ->assertOk()
            ->assertJsonStructure(['data'=>["*" => ['id', 'price_reg', 'price_sale']]])
            ->assertJsonCount(2,'data');
    }


}
