<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\ProductOptionTranslationRequest;
use App\Api\Admin\ProductOptions\Requests\ProductOptionValueTranslationRequest;
use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionTranslation;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValueTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductOptionTranslationControllerTest extends ControllerTestCase
{
    private ProductOption $productOption;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->productOption = ProductOption::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_product_option_translation()
    {
        ProductOptionTranslationRequest::fake();
        $this->putJson(route('admin.product-option.translation.update',[$this->productOption,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','name','display']);

        $this->assertDatabaseCount(ProductOptionTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_product_option_translation()
    {
        ProductOptionTranslation::factory()->create();
        ProductOptionTranslationRequest::fake(['name' => 'test','display'=>'test']);

        $this->putJson(route('admin.product-option.translation.update', [$this->productOption,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(ProductOptionTranslation::Table(),['name'=>'test','display'=>'test']);
    }
     /** @test */
     public function can_get_product_option_translation()
     {
        ProductOptionTranslation::factory()->create();
         $this->getJson(route('admin.product-option.translation.show', [$this->productOption,$this->language->id]))
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
        ProductOptionTranslationRequest::fake(['name' => '']);

        $this->putJson(route('admin.product-option.translation.update',[$this->productOption,$this->language->id]))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductOptionTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductOptionTranslationRequest::fake();

        $this->putJson(route('admin.product-option.translation.update',[$this->productOption,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductOptionTranslation::Table(), 0);
    }
}
