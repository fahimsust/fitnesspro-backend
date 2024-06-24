<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductFulfillmentRuleControllerTest extends ControllerTestCase
{
    public Product $product;
    public FulfillmentRule $fulFillmentRule;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->fulFillmentRule = FulfillmentRule::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_set_product_full_fillment_rule()
    {
        $this->postJson(route('admin.product.fulfillment-rule', [$this->product]), ['fulfillment_rule_id' => $this->fulFillmentRule->id])
            ->assertCreated()
            ->assertJsonStructure(['id', 'name', 'any_all']);

        $this->assertEquals($this->fulFillmentRule->id, $this->product->refresh()->fulfillment_rule_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product.fulfillment-rule', [$this->product]), ['fulfillment_rule_id' => 0])
            ->assertJsonValidationErrorFor('fulfillment_rule_id')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product.fulfillment-rule', [$this->product]), ['fulfillment_rule_id' => $this->fulFillmentRule->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
