<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryTranslationMetaDataRequest;
use Domain\Locales\Models\Language;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryTranslationMetaDataControllerTest extends ControllerTestCase
{
    private Category $category;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->category = Category::factory()->create();
        $this->language = Language::factory()->create();
        CategoryTranslation::factory()->create();
    }

    /** @test */
    public function can_update_Category_translation_meta()
    {
        CategoryTranslationMetaDataRequest::fake(['meta_title' => 'test']);

        $this->putJson(route('admin.category.meta-translation.update', [$this->category,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(CategoryTranslation::Table(),['meta_title'=>'test']);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CategoryTranslationMetaDataRequest::fake(['meta_title' => 100]);

        $this->putJson(route('admin.category.meta-translation.update', [$this->category,$this->language->id]))
            ->assertJsonValidationErrorFor('meta_title')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CategoryTranslationMetaDataRequest::fake();

        $this->putJson(route('admin.category.meta-translation.update', [$this->category,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
