<?php

namespace Tests\Feature\App\Api\Admin\Reviews\Controllers;

use Domain\Products\Models\Product\ProductReview;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ReviewStatusControllerTest extends ControllerTestCase
{
    public ProductReview $productReview;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productReview = ProductReview::factory()->create(['approved' => false]);
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_approve_review()
    {
        $this->postJson(route('admin.product-review.status', [$this->productReview]), ['approved' => true])
            ->assertCreated()
            ->assertJsonStructure(['approved']);

        $this->assertTrue($this->productReview->refresh()->approved);
    }

    /** @test */
    public function can_disapprove_review()
    {
        $this->productReview->update(['approved' => true]);
        $this->postJson(route('admin.product-review.status', [$this->productReview]), ['approved' => false])
            ->assertCreated()
            ->assertJsonStructure(['approved']);

        $this->assertFalse($this->productReview->refresh()->approved);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product-review.status', [$this->productReview]), ['approved' => ""])
            ->assertJsonValidationErrorFor('approved')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product-review.status', [$this->productReview]), ['approved' => false])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertFalse($this->productReview->refresh()->approved);
    }
}
