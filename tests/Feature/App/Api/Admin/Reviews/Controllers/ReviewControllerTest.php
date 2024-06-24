<?php

namespace Tests\Feature\App\Api\Admin\Reviews\Controllers;

use App\Api\Admin\Reviews\Requests\ReviewRequest;
use Domain\Products\Enums\ProductReviewItem;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductReview;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ReviewControllerTest extends ControllerTestCase
{
    public Product $product;
    public AttributeOption $attributeOption;
    public Collection $productReviews;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->attributeOption = AttributeOption::factory()->create();
        $this->productReviews = ProductReview::factory(5)->create(['name' => 'Testing', 'comment' => 'Testing comment']);
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_review()
    {
        ReviewRequest::fake(['name' => 'test']);

        $this->putJson(route('admin.product-review.update', [$this->productReviews->first()]))
            ->assertCreated();

        $this->assertEquals('test', $this->productReviews->first()->refresh()->name);
    }

    /** @test */
    public function can_delete_review()
    {
        $this->deleteJson(route('admin.product-review.destroy', [$this->productReviews->first()]))
            ->assertOk();

        $this->assertDatabaseCount(ProductReview::Table(), 4);
    }

    /** @test */
    public function can_list_review()
    {
        $this->getJson(route('admin.product-review.index'))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'comment',
                    'rating'
                ]
            ]])
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function can_search_review()
    {
        $response = $this->getJson(
            route('admin.product-review.index'),
            ["perPage" => 20, "page" => 1, 'keyword' => 'Testing']
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'comment',
                    'rating'
                ]
            ]])
            ->assertJsonCount(5, 'data');

        $this->assertEquals(1, $response['current_page']);
    }


    /** @test */
    public function can_search_review_by_attribute_id()
    {
        $attributeOption = AttributeOption::factory()->create(['id' => 50]);
        ProductReview::factory(5)->create(['item_type' => ProductReviewItem::ATTRIBUTE, 'item_id' => $attributeOption->id]);
        $this->getJson(
            route('admin.product-review.index',['item_id' => $attributeOption->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'comment',
                    'rating'
                ]
            ]])->assertJsonCount(5, 'data');
    }

    /** @test */
    public function can_search_review_by_product_id()
    {
        $product = Product::factory()->create(['id' => 100]);
        ProductReview::factory(5)->create(['item_type' => ProductReviewItem::PRODUCT, 'item_id' => $product->id]);
        $this->getJson(
            route('admin.product-review.index',['item_id' => $product->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'comment',
                    'rating'
                ]
            ]])
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ReviewRequest::fake(['name' => '']);
        $this->putJson(route('admin.product-review.update', [$this->productReviews->first()]))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ReviewRequest::fake(['name' => 'test']);

        $this->putJson(route('admin.product-review.update', [$this->productReviews->first()]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }


}
