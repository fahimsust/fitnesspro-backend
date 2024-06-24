<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductTranslationBasicsRequest;
use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductTranslationControllerTest extends ControllerTestCase
{
    private Product $product;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->product = Product::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_product_translation()
    {
        ProductTranslationBasicsRequest::fake();
        $this->putJson(route('admin.product.translation.update',[$this->product,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','title']);

        $this->assertDatabaseCount(ProductTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_product_translation()
    {
        ProductTranslation::factory()->create();
        ProductTranslationBasicsRequest::fake(['subtitle' => 'test content','title'=>'test']);

        $this->putJson(route('admin.product.translation.update', [$this->product,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(ProductTranslation::Table(),['subtitle'=>'test content','title'=>'test']);
    }
     /** @test */
     public function can_get_product_translation()
     {
         ProductTranslation::factory()->create();
         $this->getJson(route('admin.product.translation.show', [$this->product,$this->language->id]))
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
        ProductTranslationBasicsRequest::fake(['title' => '']);

        $this->putJson(route('admin.product.translation.update',[$this->product,$this->language->id]))
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductTranslationBasicsRequest::fake();

        $this->putJson(route('admin.product.translation.update',[$this->product,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductTranslation::Table(), 0);
    }
}
