<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Controllers;

use Domain\Content\Models\Image;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductOptionValueImageControllerTest extends ControllerTestCase
{
    public ProductOptionValue $productOptionValue;
    public Image $image;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productOptionValue = ProductOptionValue::factory()->create();
        $this->image = Image::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_add_image()
    {
        $this->postJson(route('admin.product-option-value.image.store', [$this->productOptionValue]), ['image_id' => $this->image->id])
            ->assertCreated()
            ->assertJsonStructure(['image_id']);

        $this->assertEquals($this->productOptionValue->refresh()->image_id, $this->image->id);
    }

    /** @test */
    public function can_remove_image()
    {
        $this->productOptionValue->update(['image_id' => $this->image->id]);

        $this->postJson(route('admin.product-option-value.image.store', [$this->productOptionValue]), ['image_id' => null])
            ->assertCreated()
            ->assertJsonStructure(['image_id']);

        $this->assertNull($this->productOptionValue->refresh()->image_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product-option-value.image.store', [$this->productOptionValue]), ['image_id' => 0])
            ->assertJsonValidationErrorFor('image_id')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product-option-value.image.store', [$this->productOptionValue]), ['image_id' => $this->image->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductOptionValue::Table(), 1);
    }
}
