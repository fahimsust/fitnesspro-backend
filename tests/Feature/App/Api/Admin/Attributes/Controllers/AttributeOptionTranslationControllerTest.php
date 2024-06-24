<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeOptionTranslationRequest;
use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeOptionTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AttributeOptionTranslationControllerTest extends ControllerTestCase
{
    private AttributeOption $attributeOption;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->attributeOption = AttributeOption::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_attribute_option_translation()
    {
        AttributeOptionTranslationRequest::fake();
        $this->putJson(route('admin.attribute-option.translation.update', [$this->attributeOption, $this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id', 'display']);

        $this->assertDatabaseCount(AttributeOptionTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_attribute_option_translation()
    {
        AttributeOptionTranslation::factory()->create();
        AttributeOptionTranslationRequest::fake(['display' => 'test']);

        $this->putJson(route('admin.attribute-option.translation.update', [$this->attributeOption, $this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(AttributeOptionTranslation::Table(), ['display' => 'test']);
    }
    /** @test */
    public function can_get_attribute_option_translation()
    {
        AttributeOptionTranslation::factory()->create();
        $this->getJson(route('admin.attribute-option.translation.show', [$this->attributeOption, $this->language->id]))
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
        AttributeOptionTranslationRequest::fake(['display' => '']);

        $this->putJson(route('admin.attribute-option.translation.update', [$this->attributeOption, $this->language->id]))
            ->assertJsonValidationErrorFor('display')
            ->assertStatus(422);

        $this->assertDatabaseCount(AttributeOptionTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        AttributeOptionTranslationRequest::fake();

        $this->putJson(route('admin.attribute-option.translation.update', [$this->attributeOption, $this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(AttributeOptionTranslation::Table(), 0);
    }
}
