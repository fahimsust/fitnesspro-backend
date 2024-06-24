<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeOptionRequest;
use App\Api\Admin\Attributes\Requests\AttributeOptionUpdateRequest;
use Domain\Discounts\Models\Rule\Condition\ConditionAttribute;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Actions\Attributes\CreateAttributeOption;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AttributeOptionControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_attribute_option()
    {
        AttributeOptionRequest::fake();
        $this->postJson(route('admin.attribute-option.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(AttributeOption::Table(), 1);
    }

    /** @test */
    public function can_get_all_attribute_Option()
    {
        $attribute = Attribute::factory()->create();
        AttributeOption::factory(30)->create(['attribute_id' => $attribute->id]);

        $response = $this->getJson(route('admin.attribute-options.list', ["per_page" => 5, "page" => 1,'attribute_id' => $attribute->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'display',
                        'rank'
                    ]
                ]
            ])
            ->assertJsonCount(5, 'data');
        $this->assertEquals(1, $response['current_page']);
    }

    /** @test */
    public function can_update_attribute_option()
    {
        $atributeOption = AttributeOption::factory()->create();
        AttributeOptionUpdateRequest::fake(['display' => "test"]);

        $this->putJson(route('admin.attribute-option.update', [$atributeOption]))
            ->assertCreated();

        $this->assertEquals('test', $atributeOption->refresh()->display);
    }

    /** @test */
    public function can_delete_attribute_option()
    {
        $atributeOption = AttributeOption::factory()->create();

        $this->deleteJson(route('admin.attribute-option.destroy', [$atributeOption]))
            ->assertOk();

        $this->assertDatabaseCount(AttributeOption::Table(), 0);
    }

    /** @test */
    public function can_get_exception_for_product_exists()
    {
        $atributeOption = AttributeOption::factory()->create();
        ProductAttribute::factory(2)
            ->sequence(
                fn($sequence) => ['product_id' => Product::factory()->create()->id],
            )
            ->create();

        $response = $this->deleteJson(route('admin.attribute-option.destroy', [$atributeOption]))
            ->assertStatus(500);
        $this->assertStringContainsString('there are products using this option', $response['message']);

        $this->assertDatabaseCount(AttributeOption::Table(), 1);
    }

    /** @test */
    public function can_search_attribute_option()
    {
        AttributeOption::factory()->create(['display' => 'test1']);
        AttributeOption::factory()->create(['display' => 'test2']);
        AttributeOption::factory()->create(['display' => 'not_match']);

        $this->getJson(
            route('admin.attribute-option-search', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'display',
                ]
            ]])->assertJsonCount(2, 'data');
    }
    /** @test */
    public function can_search_attribute_option_for_discount_condition()
    {
        $discountCondition = DiscountCondition::factory()->create();
        $attributeOptions = AttributeOption::factory(10)->create();
        ConditionAttribute::factory()->create(['attributevalue_id' => $attributeOptions[0]->id,'condition_id'=>$discountCondition->id]);
        ConditionAttribute::factory()->create(['attributevalue_id' => $attributeOptions[1]->id,'condition_id'=>$discountCondition->id]);
        ConditionAttribute::factory()->create(['attributevalue_id' => $attributeOptions[2]->id,'condition_id'=>$discountCondition->id]);
        $this->getJson(
            route('admin.attribute-option-search', ['condition_id' => $discountCondition->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'display',
                ]
            ]])->assertJsonCount(7, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        AttributeOptionRequest::fake(['display' => '']);
        $this->postJson(route('admin.attribute-option.store'))
            ->assertJsonValidationErrorFor('display')
            ->assertStatus(422);

        $this->assertDatabaseCount(AttributeOption::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateAttributeOption::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        AttributeOptionRequest::fake();

        $response = $this->postJson(route('admin.attribute-option.store'))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(AttributeOption::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        AttributeOptionRequest::fake();
        $this->postJson(route('admin.attribute-option.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(AttributeOption::Table(), 0);
    }
}
