<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\CustomFieldOptionValueRequest;
use Domain\Products\Actions\ProductOptions\SetupCustomFieldOnOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionCustom;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CustomFieldOptionValueControllerTest extends ControllerTestCase
{

    public ProductOptionValue $productOptionValue;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->productOptionValue = ProductOptionValue::factory()->create();
    }

    /** @test */
    public function can_setup_custom_field_on_option_value()
    {
        CustomFieldOptionValueRequest::fake();
        $this->postJson(
            route('admin.product-option-value.custom-field.store', $this->productOptionValue)
        )
            ->assertCreated()
            ->assertJsonStructure(['value_id']);

        $this->assertDatabaseCount(ProductOptionCustom::Table(), 1);
    }

    /** @test */
    public function can_remove_custom_field_from_option_value()
    {
        ProductOptionCustom::factory()->create();

        $this->deleteJson(
            route('admin.product-option-value.custom-field.destroy', $this->productOptionValue)
        )->assertOk();

        $this->assertDatabaseCount(ProductOptionCustom::Table(), 0);
    }

    /** @test */
    public function can_get_custom_field_of_option_value()
    {
        ProductOptionCustom::factory()->create();
        $this->getJson(route('admin.product-option-value.custom-field.index', $this->productOptionValue))
            ->assertOk()
            ->assertJsonStructure(['value_id', 'custom_label', 'custom_instruction']);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CustomFieldOptionValueRequest::fake(['custom_label' => '']);
        $this->postJson(route('admin.product-option-value.custom-field.store', $this->productOptionValue))
            ->assertJsonValidationErrorFor('custom_label')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductOptionCustom::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(SetupCustomFieldOnOptionValue::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CustomFieldOptionValueRequest::fake();

        $this->postJson(route('admin.product-option-value.custom-field.store', $this->productOptionValue))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(ProductOptionCustom::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CustomFieldOptionValueRequest::fake();

        $this->postJson(route('admin.product-option-value.custom-field.store', $this->productOptionValue))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductOptionCustom::Table(), 0);
    }
}
