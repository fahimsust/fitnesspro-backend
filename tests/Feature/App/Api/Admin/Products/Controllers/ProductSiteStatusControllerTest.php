<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Actions\Pricing\UpdateProductSiteStatus;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductSiteStatusControllerTest extends ControllerTestCase
{
    public Product $product;
    public ProductPricing $productPricingSite;
    public ProductPricing $productPricingDefault;
    public Site $site;
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->site = Site::factory()->create(['id'=>config('site.id')]);
        $this->productPricingSite = ProductPricing::factory()->create(['site_id'=>config('site.id')]);
        $this->productPricingDefault = ProductPricing::factory()->create(['site_id'=>null]);
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_change_product_pricing_site_status()
    {
        $this->postJson(route('admin.product.site-status', [$this->product]), ['status' => false,'site_id'=>$this->site->id])
            ->assertCreated()
            ->assertJsonStructure(['status']);

        $this->assertFalse($this->productPricingSite->refresh()->status);
    }
    /** @test */
    public function can_change_product_pricing_default_status()
    {
        $this->postJson(route('admin.product.site-status', [$this->product]), ['status' => false,'site_id'=>null])
            ->assertCreated()
            ->assertJsonStructure(['status']);

        $this->assertFalse($this->productPricingDefault->refresh()->status);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product.site-status', [$this->product]), ['status' => "",'site_id'=>$this->site->id])
            ->assertJsonValidationErrorFor('status')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateProductSiteStatus::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.product.site-status', [$this->product]), ['status' => false,'site_id'=>$this->site->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertTrue($this->productPricingDefault->refresh()->status);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product.site-status', [$this->product]), ['status' => false,'site_id'=>$this->site->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertTrue($this->productPricingDefault->refresh()->status);
    }
}
