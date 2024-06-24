<?php

namespace Tests\Feature\App\Api\Reviews\Controllers;

use App\Api\Site\Reviews\Requests\CreateReviewRequest;
use Domain\Products\Enums\ProductReviewItem;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductReview;
use Tests\TestCase;
use function route;

class ProductReviewsControllerTest extends TestCase
{
    public Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
    }

    /** @test */
    public function can_get_reviews()
    {
        $attributeOption = AttributeOption::factory()->create();
        ProductReview::factory(5)->create(['item_type' => ProductReviewItem::PRODUCT, 'item_id' => $this->product->id]);
        ProductReview::factory(5)->create(['item_type' => ProductReviewItem::ATTRIBUTE, 'item_id' => $attributeOption->id]);

        $this->getJson(
            route('reviews.product.list', [$this->product])
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
    public function can_create_product_review()
    {
        CreateReviewRequest::fake();

        $this->postJson(route('reviews.product.store', [$this->product]))
            ->assertCreated()
            ->assertJsonStructure([
                'id',
                'name',
                'comment',
                'rating'
            ]);

        $this->assertCount(1, $this->product->reviews);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CreateReviewRequest::fake(['name' => '']);

        $this->postJson(route('reviews.product.store', [$this->product]))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);
    }


}
