<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeSetTranslationRequest;
use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AttributeSetTranslationControllerTest extends ControllerTestCase
{
    private AttributeSet $attributeSet;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->attributeSet = AttributeSet::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_attribute_set_translation()
    {
        AttributeSetTranslationRequest::fake();
        $this->putJson(route('admin.attribute-set.translation.update',[$this->attributeSet,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','name']);

        $this->assertDatabaseCount(AttributeSetTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_attribute_set_translation()
    {
        AttributeSetTranslation::factory()->create();
        AttributeSetTranslationRequest::fake(['name'=>'test']);

        $this->putJson(route('admin.attribute-set.translation.update', [$this->attributeSet,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(AttributeSetTranslation::Table(),['name'=>'test']);
    }
     /** @test */
     public function can_get_attribute_set_translation()
     {
        AttributeSetTranslation::factory()->create();
         $this->getJson(route('admin.attribute-set.translation.show', [$this->attributeSet,$this->language->id]))
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
        AttributeSetTranslationRequest::fake(['name' => '']);

        $this->putJson(route('admin.attribute-set.translation.update',[$this->attributeSet,$this->language->id]))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(AttributeSetTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        AttributeSetTranslationRequest::fake();

        $this->putJson(route('admin.attribute-set.translation.update',[$this->attributeSet,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(AttributeSetTranslation::Table(), 0);
    }
}
