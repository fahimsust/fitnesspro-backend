<?php

namespace Tests\Feature\App\Api\Reviews\Controllers;

use App\Api\Site\Reviews\Requests\CreateReviewRequest;
use Domain\Products\Enums\ProductReviewItem;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductReview;
use Tests\TestCase;
use function route;

class AttributeReviewsControllerTest extends TestCase
{
    public AttributeOption $attributeOption;

    protected function setUp(): void
    {
        parent::setUp();
        $this->attributeOption = AttributeOption::factory()->create();
    }

    /** @test */
    public function can_get_reviews()
    {
        $product = Product::factory()->create();
        ProductReview::factory(5)->create(['item_type' => ProductReviewItem::ATTRIBUTE, 'item_id' => $this->attributeOption->id]);
        ProductReview::factory(6)->create(['item_type' => ProductReviewItem::PRODUCT, 'item_id' => $product->id]);
        $this->getJson(
            route('reviews.attribute.list', [$this->attributeOption])
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
    public function can_create_attribute_review()
    {
        CreateReviewRequest::fake();

        $this->postJson(route('reviews.attribute.store', [$this->attributeOption]))
            ->assertCreated()
            ->assertJsonStructure([
                'id',
                'name',
                'comment',
                'rating'
            ]);

        $this->assertCount(1, $this->attributeOption->reviews);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CreateReviewRequest::fake(['name' => '']);

        $this->postJson(route('reviews.attribute.store', [$this->attributeOption]))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);
    }
}
