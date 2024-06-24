<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ArchiveProductsControllerTest extends ControllerTestCase
{
    public Collection $products;

    protected function setUp(): void
    {
        parent::setUp();

        $this->products = Product::factory(5)->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_archive_product()
    {
        $this->postJson(
            route('admin.products.archive'),
            ['product_ids' => [$this->products->first()->id, $this->products[1]->id]]
        )
            ->assertCreated();

        $this->assertEquals(2, Product::onlyTrashed()->count());
        $this->assertEquals(3, Product::count());
    }

    /** @test */
    public function can_restore_product()
    {
        $this->deleteAll();
        $this->postJson(route('admin.products.restore'), ['product_ids' => [$this->products->first()->id, $this->products[1]->id]])
            ->assertCreated();

        $this->assertEquals(3, Product::onlyTrashed()->count());
        $this->assertEquals(2, Product::count());
    }

    /** @test */
    public function can_validate_request_and_return_errors_for_restore()
    {
        $this->products->first()->delete();
        $this->postJson(route('admin.products.restore'), ['product_ids' => [$this->products->first()->id, $this->products[1]->id]])
            ->assertJsonValidationErrorFor('product_ids.1')
            ->assertStatus(422);
    }

    /** @test */
    public function can_validate_request_and_return_errors_for_archive()
    {
        $this->products->first()->delete();
        $this->postJson(route('admin.products.archive'), ['product_ids' => [$this->products->first()->id, $this->products[1]->id]])
            ->assertJsonValidationErrorFor('product_ids.0')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->deleteAll();

        $this->postJson(route('admin.products.restore'), ['product_ids' => [$this->products->first()->id, $this->products[1]->id]])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }

    private function deleteAll()
    {
        foreach ($this->products as $product) {
            $product->delete();
        }
    }
}
