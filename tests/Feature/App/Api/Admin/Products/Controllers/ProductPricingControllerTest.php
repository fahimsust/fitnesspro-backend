<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;


use App\Api\Admin\Products\Requests\ProductPricingRequest;
use Domain\Products\Actions\Pricing\UpdateProductPricing;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductPricingControllerTest extends ControllerTestCase
{
    public Product $product;
    private Site $site;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->product = Product::factory()->create();
        $this->site = Site::factory()->create(['id' => config('site.id')]);
    }

    /** @test */
    public function can_get_product_pricings()
    {
        $site = Site::factory()->create();
        ProductPricing::factory()->create(['product_id' => $this->product->id, 'site_id' => $this->site->id]);
        ProductPricing::factory()->create(['product_id' => $this->product->id, 'site_id' => $site->id]);
        ProductPricing::factory()->create(['product_id' => $this->product->id, 'site_id' => NULL]);

        $this->getJson(route('admin.product.pricing.index', $this->product))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'default' => [
                        "*" => ['id', 'price_reg', 'price_sale']
                    ],
                    'site' => [
                        "*" => [
                            'id', 'name', 'pricing' =>
                            ["*" => ['id', 'price_reg', 'price_sale']]
                        ]
                    ]
                ]

            )
            ->assertJsonCount(2);
    }

    /** @test */
    public function can_create_new_product_pricing()
    {
        ProductPricingRequest::fake();

        $this->postJson(route('admin.product.pricing.store', $this->product))
            ->assertCreated()
            ->assertJsonStructure(['site_id', 'product_id']);

        $this->assertDatabaseCount(ProductPricing::Table(), 1);
        $this->assertEquals($this->product->id, ProductPricing::first()->product_id);
        $this->assertEquals($this->site->id, ProductPricing::first()->site_id);
    }

    /** @test */
    public function can_update_product()
    {
        $maxQty = 11111;

        $productPricing = ProductPricing::factory(['site_id' => $this->site->id])->create();
        ProductPricingRequest::fake(['max_qty' => $maxQty]);

        $this->postJson(route('admin.product.pricing.store', $this->product))
            ->assertCreated()
            ->assertJsonStructure(['site_id', 'product_id'])
            ->assertJsonFragment([
                'site_id' => $this->site->id,
                'product_id' => $productPricing->product_id,
                'max_qty' => $maxQty
            ]);
    }

    /** @test */
    public function can_update_product_without_site()
    {
        $productPricing = ProductPricing::factory(['site_id' => null])->create();
        $maxQty = 11111;

        ProductPricingRequest::fake(['max_qty' => $maxQty, 'site_id' => null]);

        $this->postJson(route('admin.product.pricing.store', $this->product))
            ->assertCreated()
            ->assertJsonStructure(['site_id', 'product_id'])
            ->assertJsonFragment([
                'site_id' => null,
                'product_id' => $productPricing->product_id,
                'max_qty' => $maxQty
            ]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ProductPricingRequest::fake(['pricing_rule_id' => 0]);

        $this->postJson(route('admin.product.pricing.store', $this->product))
            ->assertJsonValidationErrorFor('pricing_rule_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductPricing::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateProductPricing::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        ProductPricingRequest::fake();

        $this->postJson(route('admin.product.pricing.store', $this->product))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test"]);

        $this->assertDatabaseCount(ProductPricing::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductPricingRequest::fake();

        $this->postJson(route('admin.product.pricing.store', $this->product))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductPricing::Table(), 0);
    }
}
