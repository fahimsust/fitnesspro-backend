<?php

namespace Tests\Feature\App\Api\Reviews\Controllers;

use Domain\Products\Enums\ProductReviewItem;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductReview;
use Tests\TestCase;
use function route;

class ReviewsControllerTest extends TestCase
{
    public Product $product;
    public AttributeOption $attributeOption;
    public AttributeOption $attributeOption2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->attributeOption = AttributeOption::factory()->create();
        $this->attributeOption2 = AttributeOption::factory()->create();
        ProductReview::factory(3)->create(['item_type' => ProductReviewItem::ATTRIBUTE, 'item_id' => $this->attributeOption->id]);
        ProductReview::factory(4)->create(['item_type' => ProductReviewItem::ATTRIBUTE, 'item_id' => $this->attributeOption2->id]);
        ProductReview::factory(3)->create(['item_type' => ProductReviewItem::PRODUCT, 'item_id' => $this->product->id]);
    }

    /** @test */
    public function can_get_reviews()
    {
       $this->postJson(
            route('reviews.list'), ['product_id' => $this->product->id, 'option_id' => $this->attributeOption2->id]
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
            ->assertJsonCount(7, 'data');
    }

    /** @test */
    public function can_get_reviews_for_products()
    {
        $this->postJson(
            route('reviews.list'), ['product_id' => $this->product->id]
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
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function can_get_reviews_for_option()
    {
        $this->postJson(
            route('reviews.list'), ['option_id' => $this->attributeOption2->id]
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
            ->assertJsonCount(4, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('reviews.list'), ['product_id' => $this->product->id, 'option_id' => 0]
        )
            ->assertJsonValidationErrorFor('option_id')
            ->assertStatus(422);
    }

    /** @test */
    public function can_validate_request_and_return_errors_for_both_params_null()
    {
        $this->postJson(
            route('reviews.list')
        )
            ->assertJsonValidationErrorFor('product_id')
            ->assertJsonValidationErrorFor('option_id')
            ->assertStatus(422);
    }
}
