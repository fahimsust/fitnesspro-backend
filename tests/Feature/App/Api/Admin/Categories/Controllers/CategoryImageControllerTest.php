<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Content\Models\Image;
use Domain\Products\Models\Category\Category;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryImageControllerTest extends ControllerTestCase
{
    public Category $category;
    public Image $image;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->image = Image::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_add_image()
    {
        $this->postJson(route('admin.category.image.store', [$this->category]), ['image_id' => $this->image->id])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals($this->category->refresh()->image_id, $this->image->id);
    }

    /** @test */
    public function can_remove_image()
    {
        $this->category->update(['image_id' => $this->image->id]);

        $this->postJson(route('admin.category.image.store', [$this->category]), ['image_id' => null])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertNull($this->category->refresh()->image_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.category.image.store', [$this->category]), ['image_id' => 0])
            ->assertJsonValidationErrorFor('image_id')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.category.image.store', [$this->category]), ['image_id' => $this->image->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Category::Table(), 1);
    }
}
