<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\FormSectionFieldRequest;
use App\Api\Admin\CustomForms\Requests\FormSectionFieldUpdateRequest;
use Domain\CustomForms\Models\FormSection;
use Domain\CustomForms\Models\FormSectionField;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FormSectionFieldControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_custom_form_section_field()
    {
        FormSectionFieldRequest::fake();

        $this->postJson(route('admin.custom-form-field.store'))
            ->assertCreated()
            ->assertJsonStructure(['id','section_id','field_id']);

        $this->assertDatabaseCount(FormSectionField::Table(), 1);
    }

    /** @test */
    public function can_update_custom_form_section_field()
    {
        $customFormField = FormSectionField::factory()->create(['required'=>true,'rank'=>1]);
        FormSectionFieldUpdateRequest::fake(['required' =>false, 'rank' => 3]);

        $this->putJson(route('admin.custom-form-field.update', [$customFormField]))
            ->assertCreated();

        $this->assertDatabaseHas(FormSectionField::Table(), ['required' => false, 'rank' => 3]);
    }

    /** @test */
    public function can_delete_form_section_field()
    {
        $formSectionField = FormSectionField::factory(5)->create();

        $this->deleteJson(route('admin.custom-form-field.destroy', [$formSectionField->first()]))
            ->assertOk();

        $this->assertDatabaseCount(FormSectionField::Table(), 4);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        FormSectionFieldRequest::fake(['name' => '']);

        $this->postJson(route('admin.custom-form-field.store'))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(FormSectionField::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        FormSectionFieldRequest::fake();

        $this->postJson(route('admin.custom-form-field.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(FormSectionField::Table(), 0);
    }
}
