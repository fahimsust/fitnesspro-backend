<?php

namespace Tests\Feature\App\Api\Admin\ProductTypes\Controllers;

use Domain\Products\Actions\Types\AssignTaxRuleToProductType;
use Domain\Products\Models\Product\ProductType;
use Domain\Tax\Models\TaxRule;
use Domain\Tax\Models\TaxRuleProductType;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductTypeTaxRuleControllerTest extends ControllerTestCase
{
    public ProductType $productType;
    public TaxRule $taxRule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->productType = ProductType::factory()->create();
        $this->taxRule = TaxRule::factory()->create();
    }

    /** @test */
    public function can_add_tax_rule_id_in_product_type()
    {
        $taxRules = TaxRule::factory(5)->create();
        $taxRuleIds = $taxRules->pluck('id')->toArray();

        $this->postJson(
            route('admin.product-type.tax-rule.store',$this->productType),
            ['rule_ids' => $taxRuleIds]
        )
            ->assertCreated();

        $this->assertDatabaseCount(TaxRuleProductType::Table(), 5);

        $taxRules = TaxRule::factory(10)->create();
        $taxRuleIds = $taxRules->pluck('id')->toArray();


        $this->postJson(
            route('admin.product-type.tax-rule.store',$this->productType),
            ['rule_ids' => $taxRuleIds]
        )
            ->assertCreated();

        $this->assertDatabaseCount(TaxRuleProductType::Table(), 10);
    }

    /** @test */
    public function can_delete_tax_rule_from_product_type()
    {
        TaxRuleProductType::factory()->create();

        $this->deleteJson(
            route('admin.product-type.tax-rule.destroy', [$this->productType, $this->taxRule]),
        )->assertOk();

        $this->assertDatabaseCount(TaxRuleProductType::Table(), 0);
    }

    /** @test */
    public function can_get_tax_rule()
    {
        TaxRuleProductType::factory()->create();
        $this->getJson(route('admin.product-type.tax-rule.index', $this->productType))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'name']]);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AssignTaxRuleToProductType::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.product-type.tax-rule.store', [$this->productType, $this->taxRule]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(TaxRuleProductType::Table(), 0);
    }

    /** @test */
    public function type_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product-type.tax-rule.store', [$this->productType, $this->taxRule]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(TaxRuleProductType::Table(), 0);
    }
}
