<?php

namespace Tests\Feature\App\Api\Admin\DisplayTemplates\Controllers;

use App\Api\Admin\DisplayTemplates\Requests\DisplayTemplateRequest;
use Domain\Sites\Models\Layout\DisplayTemplate;
use Domain\Sites\Models\Layout\DisplayTemplateType;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DisplayTemplateControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_display_template()
    {
        DisplayTemplateRequest::fake();
        $this->postJson(route('admin.display-template.store'))
            ->assertCreated()
            ->assertJsonStructure(['id', 'name']);

        $this->assertDatabaseCount(DisplayTemplate::Table(), 1);
    }

    /** @test */
    public function can_update_display_template()
    {
        $displayTemplate = DisplayTemplate::factory()->create();

        DisplayTemplateRequest::fake(['name' => 'test']);
        $this->putJson(route('admin.display-template.update', [$displayTemplate]))
            ->assertCreated();

        $this->assertEquals('test', $displayTemplate->refresh()->name);
    }

    /** @test */
    public function can_delete_display_template()
    {
        $displayTemplate = DisplayTemplate::factory(5)->create();

        $this->deleteJson(route('admin.display-template.destroy', [$displayTemplate->first()]))
            ->assertOk();

        $this->assertDatabaseCount(DisplayTemplate::Table(), 4);
    }

    /** @test */
    public function can_get_display_template_list()
    {
        DisplayTemplate::factory(30)->create();

        $response = $this->getJson(route('admin.display-template.index', ["per_page" => 5, "page" => 2]))
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
    public function can_search_display_template()
    {
        DisplayTemplate::factory()->create(['name' => 'test1']);
        DisplayTemplate::factory()->create(['name' => 'test2']);
        DisplayTemplate::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.display-template.index', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
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
    public function can_search_display_template_for_type()
    {
        $displayTemplateType = DisplayTemplateType::factory()->create();
        $displayTemplateType2 = DisplayTemplateType::factory()->create();
        DisplayTemplate::factory(7)->create(['type_id' => $displayTemplateType->id]);
        DisplayTemplate::factory(15)->create(['type_id' => $displayTemplateType2->id]);
        $this->getJson(
            route('admin.display-template.index', ['type_id' => $displayTemplateType->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(7, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        DisplayTemplateRequest::fake(['name' => '']);
        $this->postJson(route('admin.display-template.store'), ['name' => ''])
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(DisplayTemplate::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        DisplayTemplateRequest::fake();
        $this->postJson(route('admin.display-template.store'), ['name' => 'test'])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(DisplayTemplate::Table(), 0);
    }
}
