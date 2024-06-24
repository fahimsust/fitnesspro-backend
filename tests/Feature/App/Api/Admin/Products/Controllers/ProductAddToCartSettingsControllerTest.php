<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductAddToCartSettingsRequest;
use App\Api\Admin\Products\Requests\ProductMetaDataRequest;
use Domain\Products\Actions\Product\UpdateProductAddToCartSettings;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductAddToCartSettingsControllerTest extends ControllerTestCase
{
    public Product $product;
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_product_add_to_cart_settings()
    {
        ProductAddToCartSettingsRequest::fake(['addtocart_external_label' => 'test']);

        $this->postJson(route('admin.product.add-to-cart-settings.store', [$this->product]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test', $this->product->refresh()->addtocart_external_label);
    }

    /** @test */
    public function can_get_product_add_to_cart_settings()
    {
        $this->getJson(route('admin.product.add-to-cart-settings.index', [$this->product]))
            ->assertOk()
            ->assertJsonStructure([
                'addtocart_external_label',
                'addtocart_external_link',
                'addtocart_setting'
            ]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ProductAddToCartSettingsRequest::fake(['addtocart_external_label' => 100]);

        $this->postJson(route('admin.product.add-to-cart-settings.store', [$this->product]))
            ->assertJsonValidationErrorFor('addtocart_external_label')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateProductAddToCartSettings::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        ProductMetaDataRequest::fake();

        $this->postJson(route('admin.product.add-to-cart-settings.store', [$this->product]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductAddToCartSettingsRequest::fake();

        $this->postJson(route('admin.product.add-to-cart-settings.store', [$this->product]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
