<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\CustomFieldOptionRequest;
use Domain\CustomForms\Models\FormSectionField;
use Domain\CustomForms\Models\CustomFieldOption;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CustomFieldOptionControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_custom_form()
    {
        CustomFieldOptionRequest::fake();

        $this->postJson(route('admin.custom-field-option.store'))
            ->assertCreated()
            ->assertJsonStructure(['id', 'display']);

        $this->assertDatabaseCount(CustomFieldOption::Table(), 1);
    }

    /** @test */
    public function can_update_custom_form()
    {
        $CustomFieldOption = CustomFieldOption::factory()->create();
        CustomFieldOptionRequest::fake(['display' => 'test', 'rank' => 100]);

        $this->putJson(route('admin.custom-field-option.update', [$CustomFieldOption]))
            ->assertCreated();

        $this->assertDatabaseHas(CustomFieldOption::Table(), ['display' => 'test', 'rank' => 100]);
    }

    /** @test */
    public function can_delete_custom_form()
    {
        $CustomFieldOption = CustomFieldOption::factory(5)->create();

        $this->deleteJson(route('admin.custom-field-option.destroy', [$CustomFieldOption->first()]))
            ->assertOk();

        $this->assertDatabaseCount(CustomFieldOption::Table(), 4);
    }

    /** @test */
    public function can_get_custom_forms_list()
    {
        $formSectionField = FormSectionField::factory()->create();
        CustomFieldOption::factory(15)->create(['field_id' => $formSectionField->id]);

        $this->getJson(route('admin.custom-field-option.index', ['field_id' => $formSectionField->id]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'display',
                        'rank'
                    ]
                ]
            )->assertJsonCount(15);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CustomFieldOptionRequest::fake(['display' => '']);

        $this->postJson(route('admin.custom-field-option.store'))
            ->assertJsonValidationErrorFor('display')
            ->assertStatus(422);

        $this->assertDatabaseCount(CustomFieldOption::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CustomFieldOptionRequest::fake();

        $this->postJson(route('admin.custom-field-option.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CustomFieldOption::Table(), 0);
    }
}
