<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Products\Enums\Category\CategoryStatus;
use Domain\Products\Models\Category\Category;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryStatusControllerTest extends ControllerTestCase
{
    public Category $category;
    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_show_category()
    {
        $this->category->update(['status'=>false]);
        $this->postJson(route('admin.category.status.store', [$this->category]),['status'=>CategoryStatus::ACTIVE])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals(CategoryStatus::ACTIVE,$this->category->refresh()->status);
    }
    /** @test */
    public function can_hide_category()
    {
        $this->postJson(route('admin.category.status.store', [$this->category]),['status'=>CategoryStatus::INACTIVE])
            ->assertCreated()
            ->assertJsonStructure(['id']);
        $this->assertEquals(CategoryStatus::INACTIVE,$this->category->refresh()->status);
    }

     /** @test */
     public function can_validate_request_and_return_errors()
     {
        $this->postJson(route('admin.category.status.store', [$this->category]),['status'=>''])
             ->assertJsonValidationErrorFor('status')
             ->assertStatus(422);
     }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.category.status.store', [$this->category]),['status'=>CategoryStatus::INACTIVE])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
