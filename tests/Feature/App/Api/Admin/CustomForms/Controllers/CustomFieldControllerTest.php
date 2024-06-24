<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\CustomFieldRequest;
use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\FormSection;
use Domain\CustomForms\Models\FormSectionField;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CustomFieldControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_custom_field()
    {
        $customField = CustomField::factory()->create();
        $formSection = FormSection::factory()->create();

        $this->postJson(
            route('admin.custom-field.store'),
            ['field_id' => $customField->id, 'section_id' => $formSection->id]
        )
            ->assertCreated()
            ->assertJsonStructure(['id', 'field_id', 'section_id', 'required', 'rank', 'new_row']);

        $this->assertDatabaseCount(FormSectionField::Table(), 1);
    }

    /** @test */
    public function can_get_custom_field()
    {
        $customField = CustomField::factory()->create();

        $this->getJson(route('admin.custom-field.show', $customField->id))
            ->assertCreated()
            ->assertJsonStructure(['id', 'name', 'display', 'cssclass', 'specs', 'required', 'type', 'status', 'options']);
    }

    /** @test */
    public function can_update_custom_field()
    {
        $customField = CustomField::factory()->create();
        CustomFieldRequest::fake(['name' => 'test', 'display' => 'test']);

        $this->putJson(route('admin.custom-field.update', [$customField]))
            ->assertCreated();

        $this->assertDatabaseHas(CustomField::Table(), ['name' => 'test', 'display' => 'test']);
    }

    /** @test */
    public function can_get_custom_field_list()
    {
        CustomField::factory(15)->create();
        $this->getJson(route('admin.custom-field.index'))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'display'
                ]
            ]])->assertJsonCount(15, 'data');
    }

    /** @test */
    public function can_search_custom_forms()
    {
        CustomField::factory()->create(['name' => 'test1']);
        CustomField::factory()->create(['name' => 'test2']);
        CustomField::factory()->create(['name' => 'test3']);
        CustomField::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.custom-field.index', ['keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'display'
                ]
            ]])->assertJsonCount(3, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $customField = CustomField::factory()->create();
        $this->postJson(route('admin.custom-field.store'),['form_id'=>$customField->id])
            ->assertJsonValidationErrorFor('section_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(FormSectionField::Table(), 0);
    }
    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CustomFieldRequest::fake();

        $this->postJson(route('admin.custom-field.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CustomField::Table(), 0);
    }
}
