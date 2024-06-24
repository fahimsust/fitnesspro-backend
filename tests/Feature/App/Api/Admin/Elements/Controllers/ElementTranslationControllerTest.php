<?php

namespace Tests\Feature\App\Api\Admin\Elements\Controllers;

use App\Api\Admin\Elements\Requests\ElementTranslationRequest;
use Domain\Content\Models\Element;
use Domain\Content\Models\ElementTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ElementTranslationControllerTest extends ControllerTestCase
{
    private Element $element;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->element = Element::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_element_translation()
    {
        ElementTranslationRequest::fake();
        $this->putJson(route('admin.element.translation.update',[$this->element,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','content']);

        $this->assertDatabaseCount(ElementTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_element_translation()
    {
        ElementTranslation::factory()->create();
        ElementTranslationRequest::fake(['element_content' => 'test content']);

        $this->putJson(route('admin.element.translation.update', [$this->element,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(ElementTranslation::Table(),['content'=>'test content']);
    }
     /** @test */
     public function can_get_element_translation()
     {
         ElementTranslation::factory()->create();
         $this->getJson(route('admin.element.translation.show', [$this->element,$this->language->id]))
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
        ElementTranslationRequest::fake(['element_content' => 1]);

        $this->putJson(route('admin.element.translation.update',[$this->element,$this->language->id]))
            ->assertJsonValidationErrorFor('element_content')
            ->assertStatus(422);

        $this->assertDatabaseCount(ElementTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ElementTranslationRequest::fake();

        $this->putJson(route('admin.element.translation.update',[$this->element,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ElementTranslation::Table(), 0);
    }
}
