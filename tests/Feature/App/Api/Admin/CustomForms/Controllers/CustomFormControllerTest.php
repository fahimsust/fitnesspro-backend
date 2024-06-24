<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\CustomFormRequest;
use Domain\CustomForms\Actions\DeleteCustomForm;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductForm;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CustomFormControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_custom_form()
    {
        CustomFormRequest::fake();

        $this->postJson(route('admin.custom-form.store'))
            ->assertCreated()
            ->assertJsonStructure(['id', 'name','status']);

        $this->assertDatabaseCount(CustomForm::Table(), 1);
    }

    /** @test */
    public function can_update_custom_form()
    {
        $customForm = CustomForm::factory()->create();
        CustomFormRequest::fake(['name' => 'test', 'status' => true]);

        $this->putJson(route('admin.custom-form.update', [$customForm]))
            ->assertCreated();

        $this->assertDatabaseHas(CustomForm::Table(), ['name' => 'test', 'status' => true]);
    }

    /** @test */
    public function can_delete_custom_form()
    {
        $customForms = CustomForm::factory(5)->create();

        $this->deleteJson(route('admin.custom-form.destroy', [$customForms->first()]))
            ->assertOk();

        $this->assertDatabaseCount(CustomForm::Table(), 4);
    }

    /** @test */
    public function can_get_custom_forms_list()
    {
        CustomForm::factory(15)->create();
        $productForm = ProductForm::factory()->create();

        $response = $this->getJson(route('admin.custom-form.index', ['product_id'=>$productForm->product_id]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'status'
                ]
            ]])->assertJsonCount(14,'data');
    }

    /** @test */
    public function can_search_custom_forms()
    {
        CustomForm::factory()->create(['name' => 'test1']);
        CustomForm::factory()->create(['name' => 'test2']);
        CustomForm::factory()->create(['name' => 'test3']);
        CustomForm::factory()->create(['name' => 'not_match']);
        $productForm = ProductForm::factory()->create();

        $this->getJson(
            route('admin.custom-form.index',['product_id'=>$productForm->product_id, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'status'
                ]
            ]])->assertJsonCount(2, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CustomFormRequest::fake(['name' => '']);

        $this->postJson(route('admin.custom-form.store'))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(CustomForm::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(DeleteCustomForm::class)
            ->shouldReceive('handle')
            ->andThrow(new Exception("test"));

        $element = CustomForm::factory(5)->create();

        $this->deleteJson(route('admin.custom-form.destroy', [$element->first()]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(CustomForm::Table(), 5);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CustomFormRequest::fake();

        $this->postJson(route('admin.custom-form.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CustomForm::Table(), 0);
    }
}
