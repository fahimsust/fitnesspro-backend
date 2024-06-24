<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\ProductOptionValueTranslationRequest;
use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValueTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductOptionValueTranslationControllerTest extends ControllerTestCase
{
    private ProductOptionValue $productOptionValue;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->productOptionValue = ProductOptionValue::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_product_option_value_translation()
    {
        ProductOptionValueTranslationRequest::fake();
        $this->putJson(route('admin.product-option-value.translation.update',[$this->productOptionValue,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','name','display']);

        $this->assertDatabaseCount(ProductOptionValueTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_product_option_value_translation()
    {
        ProductOptionValueTranslation::factory()->create();
        ProductOptionValueTranslationRequest::fake(['name' => 'test','display'=>'test']);

        $this->putJson(route('admin.product-option-value.translation.update', [$this->productOptionValue,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(ProductOptionValueTranslation::Table(),['name'=>'test','display'=>'test']);
    }
     /** @test */
     public function can_get_product_option_value_translation()
     {
        ProductOptionValueTranslation::factory()->create();
         $this->getJson(route('admin.product-option-value.translation.show', [$this->productOptionValue,$this->language->id]))
             ->assertOk()
             ->assertJsonStructure(
                 [
                     'id',
                 ]
             );
     }


    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ProductOptionValueTranslationRequest::fake(['name' => '']);

        $this->putJson(route('admin.product-option-value.translation.update',[$this->productOptionValue,$this->language->id]))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductOptionValueTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductOptionValueTranslationRequest::fake();

        $this->putJson(route('admin.product-option-value.translation.update',[$this->productOptionValue,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductOptionValueTranslation::Table(), 0);
    }
}
