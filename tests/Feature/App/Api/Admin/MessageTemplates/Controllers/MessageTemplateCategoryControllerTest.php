<?php

namespace Tests\Feature\App\Api\Admin\MessageTemplates\Controllers;

use Domain\Messaging\Models\MessageTemplateCategory;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class MessageTemplateCategoryControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_category()
    {
        $this->postJson(route('admin.message-template-category.store'), ['name' => 'test'])
            ->assertCreated()
            ->assertJsonStructure(['id', 'name']);

        $this->assertDatabaseCount(MessageTemplateCategory::Table(), 1);
    }
    /** @test */
    public function can_get_categories()
    {
        MessageTemplateCategory::factory(100)->create();

        $this->getJson(route('admin.message-template-category.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'parent'
                ]
            ])
            ->assertJsonCount(100);
    }

    /** @test */
    public function can_update_category()
    {
        $messageTemplateCategory = MessageTemplateCategory::factory()->create();

        $this->putJson(route('admin.message-template-category.update', [$messageTemplateCategory]), ['name' => 'test'])
            ->assertCreated();

        $this->assertEquals('test', $messageTemplateCategory->refresh()->name);
    }

    /** @test */
    public function can_delete_category()
    {
        $messageTemplateCategories = MessageTemplateCategory::factory(5)->create();

        $this->deleteJson(route('admin.message-template-category.destroy', [$messageTemplateCategories->first()]))
            ->assertOk();

        $this->assertDatabaseCount(MessageTemplateCategory::Table(), 4);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.message-template-category.store'), ['name' => ''])
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(MessageTemplateCategory::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.message-template-category.store'), ['name' => 'test'])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(MessageTemplateCategory::Table(), 0);
    }
}
