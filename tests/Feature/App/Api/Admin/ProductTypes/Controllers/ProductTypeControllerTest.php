<?php

namespace Tests\Feature\App\Api\Admin\ProductTypes\Controllers;

use App\Api\Admin\Products\Requests\ProductBasicsRequest;
use Domain\Discounts\Models\Advantage\AdvantageProductType;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Rule\Condition\ConditionProductType;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Order\OrderCustomForm;
use Domain\Products\Actions\Types\CreateProductType;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductType;
use Domain\Products\Models\Product\ProductType;
use Domain\Products\Models\Product\ProductTypeAttributeSet;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductTypeControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_product_type()
    {
        $this->postJson(route('admin.product-type.store'), ['name' => 'test'])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ProductType::Table(), 1);
    }
    /** @test */
    public function can_get_product_attribute_set()
    {
        $productType = ProductType::factory()->create();
        ProductTypeAttributeSet::factory()->create(['type_id' => $productType->id]);
        $this->getJson(route('admin.product-type.show', [$productType]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'id',
                    'name',
                    'attribute_sets',
                    'tax_rules'
                ]
            );
    }
    /** @test */
    public function can_get_all_the_product_type()
    {
        ProductType::factory(30)->create();

        $this->getJson(route('admin.product-type.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(30);
    }

    /** @test */
    public function can_update_product_type()
    {
        $productType = ProductType::factory()->create();
        ProductBasicsRequest::fake(['title' => 'test']);

        $this->putJson(route('admin.product-type.update', [$productType]), ['name' => 'test'])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test', $productType->refresh()->name);
    }

    /** @test */
    public function can_delete_product_type()
    {
        $productType = ProductType::factory(5)->create();
        CategoryProductType::factory()->create(['type_id' => $productType->first()->id]);
        OrderCustomForm::factory()->create(['product_type_id' => $productType->first()->id]);

        $this->deleteJson(route('admin.product-type.destroy', [$productType->first()]))
            ->assertOk();

        $this->assertDatabaseCount(ProductType::Table(), 4);
        $this->assertDatabaseCount(CategoryProductType::Table(), 0);
        $this->assertNull(OrderCustomForm::first()->type_id);
    }

    /** @test */
    public function can_get_all_the_product_type_with_pagination()
    {
        ProductType::factory(30)->create();

        $response = $this->getJson(route('admin.product-types.list', ["per_page" => 5, "page" => 2]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])
            ->assertJsonCount(5, 'data');
        $this->assertEquals(2, $response['current_page']);
    }
    /** @test */
    public function can_search_product_type_by_attribute_set()
    {
        $productTypes = ProductType::factory(5)->create();
        ProductType::factory(4)->create();
        $attributeSet = AttributeSet::factory()->create();
        foreach ($productTypes as $value) {
            ProductTypeAttributeSet::factory()->create(['set_id' => $attributeSet->id, 'type_id' => $value->id]);
        }
        $this->getJson(route('admin.product-types.list', ['attribute_set_id' => $attributeSet->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ]
                ]
            ])->assertJsonCount(5, 'data');
    }
    /** @test */
    public function can_search_product_type()
    {
        ProductType::factory(5)->create(['name' => 'test1']);
        $response = $this->getJson(route('admin.product-types.list', ["per_page" => 20, "page" => 1, 'keyword' => 'test']))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ]
                ]
            ])->assertJsonCount(5, 'data');;
        $this->assertEquals(1, $response['current_page']);
    }
    /** @test */
    public function can_search_product_for_brand_category()
    {
        $category = Category::factory()->create();
        $types = ProductType::factory(10)->create();
        CategoryProductType::factory()->create(['type_id' => $types[0]->id, 'category_id' => $category->id]);
        CategoryProductType::factory()->create(['type_id' => $types[1]->id, 'category_id' => $category->id]);
        CategoryProductType::factory()->create(['type_id' => $types[2]->id, 'category_id' => $category->id]);
        $this->getJson(
            route('admin.product-types.list', ['category_id' => $category->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(7, 'data');
    }

    /** @test */
    public function can_search_product_for_discount_advantage()
    {
        $discountAdvantage = DiscountAdvantage::factory()->create();
        $types = ProductType::factory(10)->create();
        AdvantageProductType::factory()->create(['producttype_id' => $types[0]->id, 'advantage_id' => $discountAdvantage->id]);
        AdvantageProductType::factory()->create(['producttype_id' => $types[1]->id, 'advantage_id' => $discountAdvantage->id]);
        AdvantageProductType::factory()->create(['producttype_id' => $types[2]->id, 'advantage_id' => $discountAdvantage->id]);
        $this->getJson(
            route('admin.product-types.list', ['advantage_id' => $discountAdvantage->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(7, 'data');
    }
    /** @test */
    public function can_search_product_for_discount_condition()
    {
        $discountCondition = DiscountCondition::factory()->create();
        $types = ProductType::factory(10)->create();
        ConditionProductType::factory()->create(['producttype_id' => $types[0]->id, 'condition_id' => $discountCondition->id]);
        ConditionProductType::factory()->create(['producttype_id' => $types[1]->id, 'condition_id' => $discountCondition->id]);
        ConditionProductType::factory()->create(['producttype_id' => $types[2]->id, 'condition_id' => $discountCondition->id]);
        $this->getJson(
            route('admin.product-types.list', ['condition_id' => $discountCondition->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(7, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product-type.store'), ['name' => ''])
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductType::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateProductType::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.product-type.store'), ['name' => 'test'])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(ProductType::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product-type.store'), ['name' => 'test'])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductType::Table(), 0);
    }
}
