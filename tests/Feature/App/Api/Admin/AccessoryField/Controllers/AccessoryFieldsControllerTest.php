<?php

namespace Tests\Feature\App\Api\Admin\AccessoryField\Controllers;

use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessoryField;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AccessoryFieldsControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_accessory_field_list()
    {
        AccessoryField::factory(30)->create();

        $response = $this->getJson(route('admin.accessory-fields.list', ["per_page" => 5, "page" => 2]))
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
    public function can_search_accessory_field()
    {
        AccessoryField::factory()->create(['name' => 'test1']);
        AccessoryField::factory()->create(['name' => 'test2']);
        AccessoryField::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.accessory-fields.list', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(2, 'data');
    }
    /** @test */
    public function can_search_accesory_field_for_product_id()
    {
        $product = Product::factory()->create();
        $accessoryFields = AccessoryField::factory(10)->create();
        ProductAccessoryField::factory()->create(['accessories_fields_id' => $accessoryFields[0]->id,'product_id'=>$product->id]);
        ProductAccessoryField::factory()->create(['accessories_fields_id' => $accessoryFields[1]->id,'product_id'=>$product->id]);
        ProductAccessoryField::factory()->create(['accessories_fields_id' => $accessoryFields[2]->id,'product_id'=>$product->id]);
        $this->getJson(
            route('admin.accessory-fields.list', ['product_id' => $product->id]),
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
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->getJson(
            route('admin.accessory-fields.list', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
        ->assertStatus(401)
        ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
