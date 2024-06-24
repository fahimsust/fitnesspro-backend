<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Actions\Admin\AssignProductToDiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DiscountLevelProductControllerTest extends ControllerTestCase
{
    public Product $product;
    public DiscountLevel $discountLevel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->product = Product::factory()->create();
        $this->discountLevel = DiscountLevel::factory()->create();
    }

    /** @test */
    public function can_add_product_in_discount_level()
    {
        $this->postJson(route('admin.discount-level.product.store', $this->discountLevel), ["product_id" => $this->product->id])
            ->assertCreated()
            ->assertJsonStructure(['product_id', 'discount_level_id']);

        $this->assertDatabaseCount(DiscountLevelProduct::Table(), 1);
    }

    /** @test */
    public function can_delete_product_from_discount_level()
    {
        DiscountLevelProduct::factory()->create();

        $this->deleteJson(
            route('admin.discount-level.product.destroy', [$this->discountLevel, $this->product]),
        )->assertOk()->assertJsonStructure(['title']);

        $this->assertDatabaseCount(DiscountLevelProduct::Table(), 0);
    }

    /** @test */
    public function can_get_products()
    {
        DiscountLevelProduct::factory()->create();
        $this->getJson(route('admin.discount-level.product.index', $this->discountLevel))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'title']]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.discount-level.product.store', $this->discountLevel), ["product_id" => 0])
            ->assertJsonValidationErrorFor('product_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(DiscountLevelProduct::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AssignProductToDiscountLevel::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.discount-level.product.store', $this->discountLevel), ["product_id" => $this->product->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(DiscountLevelProduct::Table(), 0);
    }

    /** @test */
    public function type_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.discount-level.product.store', $this->discountLevel), ["product_id" => $this->product->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(DiscountLevelProduct::Table(), 0);
    }
}
