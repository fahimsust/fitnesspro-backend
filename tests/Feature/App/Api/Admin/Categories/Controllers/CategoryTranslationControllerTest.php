<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryTranslationRequest;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryTranslationControllerTest extends ControllerTestCase
{
    private Category $category;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->category = Category::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_category_translation()
    {
        CategoryTranslationRequest::fake();
        $this->putJson(route('admin.category.translation.update',[$this->category,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','title']);

        $this->assertDatabaseCount(CategoryTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_category_translation()
    {
        CategoryTranslation::factory()->create();
        CategoryTranslationRequest::fake(['description' => 'test description','title'=>'test']);

        $this->putJson(route('admin.category.translation.update', [$this->category,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(CategoryTranslation::Table(),['description'=>'test description','title'=>'test']);
    }
     /** @test */
     public function can_get_category_translation()
     {
         CategoryTranslation::factory()->create();
         $this->getJson(route('admin.category.translation.show', [$this->category,$this->language->id]))
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
        CategoryTranslationRequest::fake(['title' => '']);

        $this->putJson(route('admin.category.translation.update',[$this->category,$this->language->id]))
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(CategoryTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CategoryTranslationRequest::fake();

        $this->putJson(route('admin.category.translation.update',[$this->category,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CategoryTranslation::Table(), 0);
    }
}
