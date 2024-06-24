<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Actions\Product\CreateProductAccessoryField;
use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessoryField;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductAccessoryFieldControllerTest extends ControllerTestCase
{
    public Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_product_accessory_field()
    {
        $this->getJson(route('admin.product.accessory-field.index', [$this->product]))
            ->assertOk()
            ->assertJsonStructure(["*" => ['accessories_fields_id', 'product_id', 'accessory_field']]);
    }

    /** @test */
    public function can_create_new_product_accessory_field()
    {
        $accessories_field = AccessoryField::factory()->create();
        $this->postJson(
            route('admin.product.accessory-field.store', $this->product),
            [
                'accessories_fields_id' => $accessories_field->id,
                'rank' => 10
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(["*" => ['accessories_fields_id', 'product_id']]);

        $this->assertDatabaseCount(ProductAccessoryField::Table(), 1);
    }
    /** @test */
    public function can_update_product_accessory_field()
    {
        $productAccessoryField = ProductAccessoryField::factory()->create(['product_id' => $this->product->id, 'rank' => 1]);

        $this->postJson(
            route('admin.product.accessory-field.store', $this->product),
            [
                'accessories_fields_id' => $productAccessoryField->accessories_fields_id,
                'rank' => 10
            ]
        )
        ->assertCreated()
        ->assertJsonStructure(["*" => ['accessories_fields_id', 'product_id']]);

        $this->assertEquals(10, ProductAccessoryField::first()->rank);
        $this->assertDatabaseCount(ProductAccessoryField::Table(), 1);
    }

    /** @test */
    public function can_delete_product_accessory_field()
    {
        $productAccessoryField = ProductAccessoryField::factory(5)->create();

        $this->deleteJson(route('admin.product.accessory-field.destroy', [
            $productAccessoryField->first()->product,
            $productAccessoryField->first()->accessories_fields_id
        ]))
        ->assertOk();
        $this->assertDatabaseCount(ProductAccessoryField::Table(), 4);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $accessories_field = AccessoryField::factory()->create();

        $this->postJson(
            route('admin.product.accessory-field.store', $this->product),
            [
                'accessories_fields_id' => $accessories_field->id,
                'rank' => "abc"
            ]
        )
        ->assertJsonValidationErrorFor('rank')
        ->assertStatus(422);

        $this->assertDatabaseCount(ProductAccessoryField::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateProductAccessoryField::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $accessories_field = AccessoryField::factory()->create();

        $this->postJson(
            route('admin.product.accessory-field.store', $this->product),
            [
                'accessories_fields_id' => $accessories_field->id,
                'rank' => 1
            ]
        )
        ->assertStatus(500)
        ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(ProductAccessoryField::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $accessories_field = AccessoryField::factory()->create();

        $this->postJson(
            route('admin.product.accessory-field.store', $this->product),
            [
                'accessories_fields_id' => $accessories_field->id,
                'rank' => 1
            ]
        )
        ->assertStatus(401)
        ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductAccessoryField::Table(), 0);
    }
}
