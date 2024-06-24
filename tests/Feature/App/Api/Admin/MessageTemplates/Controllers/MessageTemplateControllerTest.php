<?php

namespace Tests\Feature\App\Api\Admin\MessageTemplates\Controllers;

use App\Api\Admin\MessageTemplates\Requests\MessageTemplateRequest;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Messaging\Models\MessageTemplateCategory;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class MessageTemplateControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    // /** @test */
    // public function can_create_new_message_template()
    // {
    //     MessageTemplateRequest::fake(['category_id' => 'new category']);
    //     $this->postJson(route('admin.message-template.store'))
    //         ->assertCreated()
    //         ->assertJsonStructure(['id', 'name']);

    //     $this->assertDatabaseCount(MessageTemplate::Table(), 1);
    //     $this->assertDatabaseCount(MessageTemplateCategory::Table(), 2);
    // }
    // /** @test */
    // public function can_create_new_message_template_with_empty_array()
    // {
    //     MessageTemplateRequest::fake(['category_id' => []]);
    //     $this->postJson(route('admin.message-template.store'))
    //         ->assertCreated()
    //         ->assertJsonStructure(['id', 'name']);

    //     $this->assertDatabaseCount(MessageTemplate::Table(), 1);
    //     $this->assertDatabaseCount(MessageTemplateCategory::Table(), 1);
    // }
    /** @test */
    public function can_create_new_message_template_with_cat_id()
    {
        $messageTemplateCategory = MessageTemplateCategory::factory()->create();
        MessageTemplateRequest::fake(['category_id' => $messageTemplateCategory->id]);
        $this->postJson(route('admin.message-template.store'))
            ->assertCreated()
            ->assertJsonStructure(['id', 'name']);

        $this->assertDatabaseCount(MessageTemplate::Table(), 1);
        $this->assertDatabaseCount(MessageTemplateCategory::Table(), 1);
    }
    /** @test */
    public function can_get_all_message_templates()
    {
        MessageTemplate::factory(100)->create();

        $this->getJson(route('admin.message-template.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(100);
    }

    /** @test */
    public function can_update_message_template()
    {
        $messageTemplate = MessageTemplate::factory()->create();

        MessageTemplateRequest::fake(['name' => 'test']);
        $this->putJson(route('admin.message-template.update', [$messageTemplate]))
            ->assertCreated();

        $this->assertEquals('test', $messageTemplate->refresh()->name);
    }

    /** @test */
    public function can_delete_message_template()
    {
        $messageTemplate = MessageTemplate::factory()->create();

        $this->deleteJson(route('admin.message-template.destroy', [$messageTemplate->first()]))
            ->assertOk();

        $this->assertDatabaseCount(MessageTemplate::Table(), 0);
    }

    /** @test */
    public function can_get_message_template_list()
    {
        MessageTemplate::factory(30)->create();

        $response = $this->getJson(route('admin.message-templates.list', ["per_page" => 5, "page" => 2]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])
            ->assertJsonCount(5, 'data');
        $this->assertEquals(2, $response['current_page']);
    }

    /** @test */
    public function can_search_message_template()
    {
        MessageTemplate::factory()->create(['name' => 'test1']);
        MessageTemplate::factory()->create(['name' => 'test2']);
        MessageTemplate::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.message-templates.list', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(2, 'data');
    }


    /** @test */
    public function can_validate_request_and_return_errors()
    {
        MessageTemplateRequest::fake(['name' => '']);
        $this->postJson(route('admin.message-template.store'))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(MessageTemplate::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        MessageTemplateRequest::fake();
        $this->postJson(route('admin.message-template.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(MessageTemplate::Table(), 0);
    }
}
