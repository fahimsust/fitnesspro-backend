<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeRequest;
use App\Api\Admin\Attributes\Requests\AttributeUpdateRequest;
use Domain\Products\Actions\Attributes\UpdateAttribute;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetAttribute;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AttributeControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_attribute()
    {
        AttributeRequest::fake();

        $this->postJson(route('admin.attribute.store'))
            ->assertCreated()
            ->assertJsonStructure(['id', 'name', 'type_id', 'show_in_details', 'show_in_search']);

        $this->assertDatabaseCount(Attribute::Table(), 1);
    }

    /** @test */
    public function can_get_all_attribute_count()
    {
        $attributeSet = AttributeSet::factory()->create();
        AttributeSetAttribute::factory(30)->create(['set_id' => $attributeSet->id]);

        $response = $this->getJson(route('admin.attributes.list', ["per_page" => 5, "page" => 1,'set_id' => $attributeSet->id]))
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
        $this->assertEquals(1, $response['current_page']);
    }

    /** @test */
    public function can_update_attribute()
    {
        $atribute = Attribute::factory()->create();
        AttributeUpdateRequest::fake(['name' => "test"]);

        $this->putJson(route('admin.attribute.update', [$atribute]))
            ->assertCreated();

        $this->assertEquals('test', $atribute->refresh()->name);
    }

    /** @test */
    public function can_delete_attribute()
    {
        $atribute = Attribute::factory()->create();
        AttributeOption::factory()->create();
        AttributeSetAttribute::factory()->create(['attribute_id' => $atribute->id]);

        $this->deleteJson(route('admin.attribute.destroy', [$atribute]))
            ->assertOk();

        $this->assertDatabaseCount(Attribute::Table(), 0);
        $this->assertDatabaseCount(AttributeSetAttribute::Table(), 0);
        $this->assertDatabaseCount(AttributeOption::Table(), 0);
    }

    /** @test */
    public function can_get_exception_for_product_exists()
    {
        $atribute = Attribute::factory()->create();
        AttributeOption::factory()->create();
        AttributeSetAttribute::factory()->create(['attribute_id' => $atribute->id]);
        ProductAttribute::factory(2)
            ->sequence(
                fn($sequence) => ['product_id' => Product::factory()->create()->id],
            )
            ->create();

        $response = $this->deleteJson(route('admin.attribute.destroy', [$atribute]))
            ->assertStatus(500);

        $this->assertStringContainsString('attribute', $response['message']);

        $this->assertDatabaseCount(Attribute::Table(), 1);
        $this->assertDatabaseCount(AttributeSetAttribute::Table(), 1);
        $this->assertDatabaseCount(AttributeOption::Table(), 1);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        AttributeRequest::fake(['name' => '']);
        $this->postJson(route('admin.attribute.store'))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(Attribute::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateAttribute::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $atribute = Attribute::factory()->create();
        AttributeRequest::fake();
        $this->putJson(route('admin.attribute.update', [$atribute]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        AttributeRequest::fake();
        $this->postJson(route('admin.attribute.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Attribute::Table(), 0);
    }
}
