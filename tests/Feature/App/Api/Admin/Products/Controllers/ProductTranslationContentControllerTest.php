<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductTranslationDetailsRequest;
use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductTranslationContentControllerTest extends ControllerTestCase
{
    private Product $product;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->product = Product::factory()->create();
        $this->language = Language::factory()->create();
        ProductTranslation::factory()->create();
    }

    /** @test */
    public function can_update_page_translation_meta()
    {
        ProductTranslationDetailsRequest::fake(['summary' => 'test']);

        $this->putJson(route('admin.product.content-translation.update', [$this->product,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(ProductTranslation::Table(),['summary'=>'test']);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ProductTranslationDetailsRequest::fake(['summary' => 100]);

        $this->putJson(route('admin.product.content-translation.update', [$this->product,$this->language->id]))
            ->assertJsonValidationErrorFor('summary')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductTranslationDetailsRequest::fake();

        $this->putJson(route('admin.product.content-translation.update', [$this->product,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
