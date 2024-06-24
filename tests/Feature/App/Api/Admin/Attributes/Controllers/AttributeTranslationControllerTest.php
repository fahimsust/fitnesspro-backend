<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeTranslationRequest;
use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AttributeTranslationControllerTest extends ControllerTestCase
{
    private Attribute $attribute;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->attribute = Attribute::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_attribute_translation()
    {
        AttributeTranslationRequest::fake();
        $this->putJson(route('admin.attribute.translation.update', [$this->attribute, $this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id', 'name']);

        $this->assertDatabaseCount(AttributeTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_attribute_translation()
    {
        AttributeTranslation::factory()->create();
        AttributeTranslationRequest::fake(['name' => 'test']);

        $this->putJson(route('admin.attribute.translation.update', [$this->attribute, $this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(AttributeTranslation::Table(), ['name' => 'test']);
    }
    /** @test */
    public function can_get_attribute_translation()
    {
        AttributeTranslation::factory()->create();
        $this->getJson(route('admin.attribute.translation.show', [$this->attribute, $this->language->id]))
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
        AttributeTranslationRequest::fake(['name' => '']);

        $this->putJson(route('admin.attribute.translation.update', [$this->attribute, $this->language->id]))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(AttributeTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        AttributeTranslationRequest::fake();

        $this->putJson(route('admin.attribute.translation.update', [$this->attribute, $this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(AttributeTranslation::Table(), 0);
    }
}
