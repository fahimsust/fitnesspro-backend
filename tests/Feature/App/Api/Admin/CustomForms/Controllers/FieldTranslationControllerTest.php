<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Controllers;

use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomFieldTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FieldTranslationControllerTest extends ControllerTestCase
{
    private CustomField $customField;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->customField = CustomField::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_form_translation()
    {
        $this->putJson(
            route(
                'admin.custom-field.translation.update',
                [$this->customField, $this->language->id]
            ),
            ['display' => 'Testing']
        )
            ->assertCreated()
            ->assertJsonStructure(['id', 'display']);

        $this->assertDatabaseCount(CustomFieldTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_form_translation()
    {
        CustomFieldTranslation::factory()->create();
        $this->putJson(
            route(
                'admin.custom-field.translation.update',
                [$this->customField, $this->language->id]
            ),
            ['display' => 'Testing']
        )
            ->assertCreated();

        $this->assertDatabaseHas(CustomFieldTranslation::Table(), ['display' => 'Testing']);
    }
    /** @test */
    public function can_get_form_translation()
    {
        CustomFieldTranslation::factory()->create();
        $this->getJson(route('admin.custom-field.translation.show', [$this->customField, $this->language->id]))
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
                'admin.custom-field.translation.update',
                [$this->customField, $this->language->id]
            ),
            ['display' => '']
        )
            ->assertJsonValidationErrorFor('display')
            ->assertStatus(422);

        $this->assertDatabaseCount(CustomFieldTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->putJson(
            route(
                'admin.custom-field.translation.update',
                [$this->customField, $this->language->id]
            ),
            ['display' => 'Testing']
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CustomFieldTranslation::Table(), 0);
    }
}
