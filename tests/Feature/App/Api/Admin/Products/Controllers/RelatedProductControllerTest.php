<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Actions\Product\CreateRelatedProduct;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductRelated;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class RelatedProductControllerTest extends ControllerTestCase
{
    public Product $product;
    public Product $relatedProduct;
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->relatedProduct = Product::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_related_product()
    {
        ProductRelated::factory(5)->create(['product_id' => $this->product->id]);

        $this->getJson(route('admin.product.related.index', $this->product))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'title', 'subtitle']]);
    }

    /** @test */
    public function can_create_new_related_product()
    {
        $this->postJson(route('admin.product.related.store', $this->product), ['related_id' => $this->relatedProduct->id])
            ->assertCreated()
            ->assertJsonStructure(["*" => ['id', 'title', 'subtitle']]);

        $this->assertDatabaseCount(ProductRelated::Table(), 1);
    }

    /** @test */
    public function can_delete_related_product()
    {
        $relatedProducts = ProductRelated::factory(5)->create();

        $this->deleteJson(route('admin.product.related.destroy', [$relatedProducts->first()->product, $relatedProducts->first()->related]))
            ->assertOk();

        $this->assertDatabaseCount(ProductRelated::Table(), 4);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product.related.store', $this->product), ['related_id' => 0])
            ->assertJsonValidationErrorFor('related_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductRelated::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateRelatedProduct::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.product.related.store', $this->product), ['related_id' => $this->relatedProduct->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(ProductRelated::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product.related.store', $this->product), ['related_id' => $this->relatedProduct->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductRelated::Table(), 0);
    }
}
