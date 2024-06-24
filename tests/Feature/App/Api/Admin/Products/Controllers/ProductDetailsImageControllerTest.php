<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Content\Models\Image;
use Domain\Products\Actions\Product\SetProductDetailsImage;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductImage;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductDetailsImageControllerTest extends ControllerTestCase
{
    public Product $product;
    public Image $image;
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->image = Image::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_set_product_details_image()
    {
        $this->postJson(route('admin.product.details-image', [$this->product]), ['details_img_id' => $this->image->id])
            ->assertCreated()
            ->assertJsonStructure(['details_img_id']);

        $this->assertEquals($this->image->id, $this->product->refresh()->details_img_id);
        $this->assertDatabaseCount(ProductImage::Table(), 1);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product.details-image', [$this->product]), ['details_img_id' => 0])
            ->assertJsonValidationErrorFor('details_img_id')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(SetProductDetailsImage::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.product.details-image', [$this->product]), ['details_img_id' => $this->image->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertNotEquals($this->image->id, $this->product->refresh()->details_img_id);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product.details-image', [$this->product]), ['details_img_id' => $this->image->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertNotEquals($this->image->id, $this->product->refresh()->details_img_id);
    }
}
