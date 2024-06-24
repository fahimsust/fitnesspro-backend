<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ArchiveProductControllerTest extends ControllerTestCase
{
    public Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_archive_product()
    {
        $this->deleteJson(route('admin.product.destroy', $this->product))
            ->assertOk();

        $this->assertSoftDeleted($this->product);
    }

    /** @test */
    public function can_restore_product()
    {
        $this->product->delete();

        $this->postJson(route('admin.product.restore', $this->product))
            ->assertCreated();

        $this->assertNotSoftDeleted($this->product);
    }


    /** @test */
    public function expect_not_found_failure_for_product_not_archived()
    {
        $this->postJson(route('admin.product.restore', $this->product))
        ->assertStatus(404);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->product->delete();

        $this->postJson(route('admin.product.store', $this->product))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
