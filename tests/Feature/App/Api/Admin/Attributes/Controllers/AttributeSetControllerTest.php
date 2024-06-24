<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Controllers;

use Domain\Products\Actions\Attributes\DeleteAttributeSet;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetAttribute;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductTypeAttributeSet;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AttributeSetControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_attribute_set()
    {
        $this->postJson(route('admin.attribute-set.store'), ['name' => 'test'])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(AttributeSet::Table(), 1);
    }

    /** @test */
    public function can_update_attribute_set()
    {
        $atributeSet = AttributeSet::factory()->create();

        $this->putJson(route('admin.attribute-set.update', [$atributeSet]), ['name' => 'test'])
            ->assertCreated();

        $this->assertEquals('test', $atributeSet->refresh()->name);
    }

    /** @test */
    public function can_delete_attribute_set()
    {
        $atributeSet = AttributeSet::factory()->create();
        AttributeSetAttribute::factory()->create();
        ProductTypeAttributeSet::factory()->create();


        $this->deleteJson(route('admin.attribute-set.destroy', [$atributeSet]))
            ->assertOk();

        $this->assertDatabaseCount(AttributeSet::Table(), 0);
        $this->assertDatabaseCount(AttributeSetAttribute::Table(), 0);
        $this->assertDatabaseCount(ProductTypeAttributeSet::Table(), 0);
    }

    /** @test */
    public function can_get_exception_for_product_exists()
    {
        $porducts = Product::factory(4)->create();
        $atributeSet = AttributeSet::factory()->create();
        AttributeSetAttribute::factory()->create();
        ProductTypeAttributeSet::factory()->create();
        AttributeOption::factory()->create();
        ProductAttribute::factory()->create(['product_id'=>$porducts[0]->id]);
        ProductAttribute::factory()->create(['product_id'=>$porducts[1]->id]);

        $response = $this->deleteJson(route('admin.attribute-set.destroy', [$atributeSet]))
            ->assertStatus(500);
        $this->assertStringContainsString('attribute set', strtolower($response['message']));

        $this->assertDatabaseCount(AttributeSet::Table(), 1);
        $this->assertDatabaseCount(AttributeSetAttribute::Table(), 1);
        $this->assertDatabaseCount(ProductTypeAttributeSet::Table(), 1);
    }

    /** @test */
    public function can_get_all_attribute_set_aith_attribute_count()
    {
        AttributeSet::factory(30)->create();
        AttributeSetAttribute::factory(5)->create();

        $response = $this->getJson(route('admin.attribute-sets.list', ["per_page" => 5, "page" => 1]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name'
                    ]
                ]
            ])
            ->assertJsonCount(5, 'data');
        $this->assertEquals(5, $response['data'][0]['attributes_count']);
        $this->assertEquals(1, $response['current_page']);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.attribute-set.store'), ['name' => ''])
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(AttributeSet::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(DeleteAttributeSet::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $atributeSet = AttributeSet::factory()->create();

        $this->deleteJson(route('admin.attribute-set.destroy', [$atributeSet]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(AttributeSet::Table(), 1);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.attribute-set.store'), ['name' => 'test'])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(AttributeSet::Table(), 0);
    }
}
