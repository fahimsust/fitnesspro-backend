<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Controllers;

use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\CustomFormTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FormTranslationControllerTest extends ControllerTestCase
{
    private CustomForm $customForm;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->customForm = CustomForm::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_form_translation()
    {
        $this->putJson(
            route(
                'admin.custom-form.translation.update',
                [$this->customForm, $this->language->id]
            ),
            ['name' => 'Testing']
        )
            ->assertCreated()
            ->assertJsonStructure(['id', 'name']);

        $this->assertDatabaseCount(CustomFormTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_form_translation()
    {
        CustomFormTranslation::factory()->create();
        $this->putJson(
            route(
                'admin.custom-form.translation.update',
                [$this->customForm, $this->language->id]
            ),
            ['name' => 'Testing']
        )
            ->assertCreated();

        $this->assertDatabaseHas(CustomFormTranslation::Table(), ['name' => 'Testing']);
    }
    /** @test */
    public function can_get_form_translation()
    {
        CustomFormTranslation::factory()->create();
        $this->getJson(route('admin.custom-form.translation.show', [$this->customForm, $this->language->id]))
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
                'admin.custom-form.translation.update',
                [$this->customForm, $this->language->id]
            ),
            ['name' => '']
        )
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(CustomFormTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->putJson(
            route(
                'admin.custom-form.translation.update',
                [$this->customForm, $this->language->id]
            ),
            ['name' => 'Testing']
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CustomFormTranslation::Table(), 0);
    }
}
