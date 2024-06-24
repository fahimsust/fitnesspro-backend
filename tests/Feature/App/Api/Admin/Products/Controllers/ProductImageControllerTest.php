<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductImageRequest;
use App\Api\Admin\Products\Requests\UpdateProductImageRequest;
use Domain\Content\Models\Image;
use Domain\Products\Actions\Product\AssignImageToProduct;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductImage;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductImageControllerTest extends ControllerTestCase
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
    public function can_get_product_images()
    {
        ProductImage::factory(5)->create(['product_id' => $this->product->id]);

        $this->getJson(route('admin.product.image.index', $this->product))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'name', 'filename']]);
    }

    /** @test */
    public function can_update_product_image()
    {
        ProductImage::factory()->create(['image_id' => $this->image->id]);
        UpdateProductImageRequest::fake(['caption' => 'test']);

        $this->putJson(route('admin.product.image.update', [$this->product, $this->image]))
            ->assertCreated()
            ->assertJsonStructure(['rank', 'caption', 'show_in_gallery']);

        $this->assertEquals('test', ProductImage::first()->caption);
    }

    /** @test */
    public function can_create_new_product_image()
    {
        ProductImageRequest::fake(['image_id' => $this->image->id]);

        $this->postJson(route('admin.product.image.store', $this->product))
            ->assertCreated()
            ->assertJsonStructure(['rank', 'caption', 'show_in_gallery']);

        $this->assertDatabaseCount(ProductImage::Table(), 1);
    }

    /** @test */
    public function can_delete_product_image()
    {
        $productImages = ProductImage::factory(5)->create();

        $this->deleteJson(route('admin.product.image.destroy', [
            $productImages->first()->product,
            $productImages->first()->image
        ]))
            ->assertOk();

        $this->assertDatabaseCount(ProductImage::Table(), 4);
    }

    /** @test */
    public function can_get_exception_for_product_detail_image()
    {
        $productImages = ProductImage::factory(5)->create();
        $product = $productImages->first()->product;
        $product->details_img_id = $productImages->first()->image->id;
        $product->save();

        $response = $this->deleteJson(route('admin.product.image.destroy', [
            $productImages->first()->product,
            $productImages->first()->image
        ]))
        ->assertStatus(409);

        $this->assertDatabaseCount(ProductImage::Table(), 5);
        $this->assertStringContainsString('details', strtolower($response['message']));
    }
    /** @test */
    public function can_get_exception_for_product_category_images()
    {
        $productImages = ProductImage::factory(5)->create();
        $product = $productImages->first()->product;
        $product->category_img_id = $productImages->first()->image->id;
        $product->save();

        $response = $this->deleteJson(route('admin.product.image.destroy', [
            $productImages->first()->product,
            $productImages->first()->image
        ]))
        ->assertStatus(409);

        $this->assertDatabaseCount(ProductImage::Table(), 5);
        $this->assertStringContainsString('category', strtolower($response['message']));
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ProductImageRequest::fake(['image_id' => 0]);
        $this->postJson(route('admin.product.image.store', $this->product))
            ->assertJsonValidationErrorFor('image_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductImage::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AssignImageToProduct::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        ProductImageRequest::fake(['image_id' => $this->image->id]);

        $this->postJson(route('admin.product.image.store', $this->product))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(ProductImage::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductImageRequest::fake(['image_id' => $this->image->id]);

        $this->postJson(route('admin.product.image.store', $this->product))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductImage::Table(), 0);
    }
}
