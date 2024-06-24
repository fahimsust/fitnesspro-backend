<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Actions\Pricing\GetProductPricing;
use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductSitePricingRuleControllerTest extends ControllerTestCase
{
    public Product $product;
    private Site $site;
    private PricingRule $pricingRule;
    private ProductPricing $productPricing;


    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->product = Product::factory()->create();
        $this->site = Site::factory()->create(['id' => config('site.id')]);
        $this->productPricing = ProductPricing::factory(['site_id' => $this->site->id])->create();
        $this->pricingRule = PricingRule::factory()->create();
    }

    /** @test */
    public function can_update_product_site_pricing_rule()
    {
        $this->postJson(route('admin.product.pricing-rule', $this->product),['site_id'=>$this->site->id,'pricing_rule_id'=>$this->pricingRule->id])
            ->assertCreated()
            ->assertJsonStructure(['pricing_rule_id'])
            ->assertJsonFragment([
                'site_id' => $this->site->id,
                'pricing_rule_id' => $this->pricingRule->id
            ]);
        $this->assertEquals($this->pricingRule->id,$this->productPricing->refresh()->pricing_rule_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product.pricing-rule', $this->product),['site_id'=>$this->site->id,'pricing_rule_id'=>0])
            ->assertJsonValidationErrorFor('pricing_rule_id')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product.pricing-rule', $this->product),['site_id'=>$this->site->id,'pricing_rule_id'=>$this->pricingRule->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertNotEquals($this->pricingRule->id,$this->productPricing->pricing_rule_id);
    }
}
