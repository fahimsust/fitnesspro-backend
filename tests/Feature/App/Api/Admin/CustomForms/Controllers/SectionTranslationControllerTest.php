<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Controllers;

use Domain\CustomForms\Models\FormSection;
use Domain\CustomForms\Models\FormSectionTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SectionTranslationControllerTest extends ControllerTestCase
{
    private FormSection $formSection;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->formSection = FormSection::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_form_translation()
    {
        $this->putJson(
            route(
                'admin.custom-form-section.translation.update',
                [$this->formSection, $this->language->id]
            ),
            ['title' => 'Testing']
        )
            ->assertCreated()
            ->assertJsonStructure(['id', 'title']);

        $this->assertDatabaseCount(FormSectionTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_form_translation()
    {
        FormSectionTranslation::factory()->create();
        $this->putJson(
            route(
                'admin.custom-form-section.translation.update',
                [$this->formSection, $this->language->id]
            ),
            ['title' => 'Testing']
        )
            ->assertCreated();

        $this->assertDatabaseHas(FormSectionTranslation::Table(), ['title' => 'Testing']);
    }
    /** @test */
    public function can_get_form_translation()
    {
        FormSectionTranslation::factory()->create();
        $this->getJson(route('admin.custom-form-section.translation.show', [$this->formSection, $this->language->id]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'id',
                ]
            );
    }


    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->putJson(
            route(
                'admin.custom-form-section.translation.update',
                [$this->formSection, $this->language->id]
            ),
            ['title' => '']
        )
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(FormSectionTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->putJson(
            route(
                'admin.custom-form-section.translation.update',
                [$this->formSection, $this->language->id]
            ),
            ['title' => 'Testing']
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(FormSectionTranslation::Table(), 0);
    }
}
