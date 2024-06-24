<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\FormSectionRequest;
use Domain\CustomForms\Actions\DeleteFormSection;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\FormSection;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FormSectionControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_custom_form_section()
    {
        FormSectionRequest::fake();

        $this->postJson(route('admin.custom-form-section.store'))
            ->assertCreated()
            ->assertJsonStructure(['id','title','rank']);

        $this->assertDatabaseCount(FormSection::Table(), 1);
    }

    /** @test */
    public function can_update_custom_form_section()
    {
        $formSection = FormSection::factory()->create();
        FormSectionRequest::fake(['title' => 'test', 'rank' => 3]);

        $this->putJson(route('admin.custom-form-section.update', [$formSection]))
            ->assertCreated();

        $this->assertDatabaseHas(FormSection::Table(), ['title' => 'test', 'rank' => 3]);
    }

    /** @test */
    public function can_delete_form_section()
    {
        $formSection = FormSection::factory(5)->create();

        $this->deleteJson(route('admin.custom-form-section.destroy', [$formSection->first()]))
            ->assertOk();

        $this->assertDatabaseCount(FormSection::Table(), 4);
    }

    /** @test */
    public function can_get_section_list()
    {
        $cutomForms = CustomForm::factory(2)->create();
        FormSection::factory(10)->create(['form_id'=>$cutomForms[0]->id]);
        FormSection::factory(10)->create(['form_id'=>$cutomForms[1]->id]);

        $this->getJson(route('admin.custom-form-section.index', ['form_id'=>$cutomForms[0]->id]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'rank',
                    'fields'
                ]
            ])->assertJsonCount(10);
    }



    /** @test */
    public function can_validate_request_and_return_errors()
    {
        FormSectionRequest::fake(['title' => '']);

        $this->postJson(route('admin.custom-form-section.store'))
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(FormSection::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(DeleteFormSection::class)
            ->shouldReceive('handle')
            ->andThrow(new Exception("test"));

        $formSections = FormSection::factory(5)->create();

        $this->deleteJson(route('admin.custom-form-section.destroy', [$formSections->first()]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(FormSection::Table(), 5);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        FormSectionRequest::fake();

        $this->postJson(route('admin.custom-form-section.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(FormSection::Table(), 0);
    }
}
