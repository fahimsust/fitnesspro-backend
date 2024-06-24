<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductForm;
use Domain\Products\Actions\Product\SetProductCustomForm;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductFormControllerTest extends ControllerTestCase
{
    public Product $product;
    public CustomForm $customForm;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->customForm = CustomForm::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_product_custom_form()
    {
        ProductForm::factory(5)->create(['product_id' => $this->product->id]);

        $this->getJson(route('admin.product.form.index', $this->product))
            ->assertOk()
            ->assertJsonStructure(["product_forms" => ['*'=>['id', 'rank', 'form'=>['id','name','status']]]])
            ->assertJsonCount(5,'product_forms');
    }

    /** @test */
    public function can_add_product_custom_form()
    {
        $this->postJson(route('admin.product.form.store', [$this->product]),['form_id'=>$this->customForm->id])
            ->assertCreated()
            ->assertJsonStructure(['rank', 'product_id', 'form_id']);

        $this->assertDatabaseCount(ProductForm::Table(), 1);
        $this->assertEquals($this->customForm->id, ProductForm::first()->form_id);
    }

    /** @test */
    public function can_remove_product_custom_form()
    {
        $productForms = ProductForm::factory(5)->create();

        $this->deleteJson(route('admin.product.form.destroy', [
            $productForms->first()->product,
            $productForms->first()->form
        ]))->assertOk();

        $this->assertDatabaseCount(ProductForm::Table(), 4);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product.form.store', [$this->product]),['form_id'=>0])
            ->assertJsonValidationErrorFor('form_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductForm::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(SetProductCustomForm::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.product.form.store', [$this->product]),['form_id'=>$this->customForm->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(ProductForm::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product.form.store', [$this->product]),['form_id'=>$this->customForm->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductForm::Table(), 0);
    }
}
