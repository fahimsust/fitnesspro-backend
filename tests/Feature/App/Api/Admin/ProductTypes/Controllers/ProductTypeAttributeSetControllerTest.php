<?php

namespace Tests\Feature\App\Api\Admin\ProductTypes\Controllers;

use Domain\Products\Actions\Types\AssignAttributeSetToProductType;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Product\ProductType;
use Domain\Products\Models\Product\ProductTypeAttributeSet;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductTypeAttributeSetControllerTest extends ControllerTestCase
{
    public ProductType $productType;
    public AttributeSet $attributeSet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->productType = ProductType::factory()->create();
        $this->attributeSet = AttributeSet::factory()->create();
    }

    /** @test */
    public function can_add_attribute_set_in_product_type()
    {
        $attributeSets = AttributeSet::factory(5)->create();
        $setIds = $attributeSets->pluck('id')->toArray();

        $this->postJson(
            route('admin.product-type.attribute-set.store',$this->productType),
            ['set_ids' => $setIds]
        )
            ->assertCreated();

        $this->assertDatabaseCount(ProductTypeAttributeSet::Table(), 5);

        $attributeSets = AttributeSet::factory(10)->create();
        $setIds = $attributeSets->pluck('id')->toArray();

        $this->postJson(
            route('admin.product-type.attribute-set.store',$this->productType),
            ['set_ids' => $setIds]
        )
            ->assertCreated();

        $this->assertDatabaseCount(ProductTypeAttributeSet::Table(), 10);
    }

    /** @test */
    public function can_delete_attribute_set_from_product_type()
    {
        ProductTypeAttributeSet::factory()->create();

        $this->deleteJson(
            route('admin.product-type.attribute-set.destroy', [$this->productType, $this->attributeSet]),
        )->assertOk();

        $this->assertDatabaseCount(ProductTypeAttributeSet::Table(), 0);
    }

    /** @test */
    public function can_get_attribute_set()
    {
        ProductTypeAttributeSet::factory()->create();
        $this->getJson(route('admin.product-type.attribute-set.index', $this->productType))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'name']]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product-type.attribute-set.store', $this->productType), ["set_ids" => 0])
            ->assertJsonValidationErrorFor('set_ids')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductTypeAttributeSet::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AssignAttributeSetToProductType::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.product-type.attribute-set.store', $this->productType), ["set_ids" => [$this->attributeSet->id]])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(ProductTypeAttributeSet::Table(), 0);
    }

    /** @test */
    public function type_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product-type.attribute-set.store', $this->productType), ["set_ids" => [$this->attributeSet->id]])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductTypeAttributeSet::Table(), 0);
    }
}
