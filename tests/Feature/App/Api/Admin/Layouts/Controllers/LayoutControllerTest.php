<?php

namespace Tests\Feature\App\Api\Admin\Layouts\Controllers;

use Domain\Sites\Models\Layout\Layout;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class LayoutControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_layout()
    {
        Layout::factory(15)->create();

        $this->getJson(route('admin.layout.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])->assertJsonCount(15);
    }

    /** @test */
    public function can_create_new_layout()
    {
        $this->postJson(route('admin.layout.store'),['name'=>'test','file' => 'test file'])
            ->assertCreated()
            ->assertJsonStructure(['id', 'name']);

        $this->assertDatabaseCount(Layout::Table(), 1);
    }
    /** @test */
    public function can_update_layout()
    {
        $layout = Layout::factory()->create();

        $this->putJson(route('admin.layout.update', [$layout]), ['name' => 'test','file' => 'test file'])
            ->assertCreated();

        $this->assertEquals('test', $layout->refresh()->name);
    }

    /** @test */
    public function can_delete_layout()
    {
        $layout = Layout::factory(5)->create();

        $this->deleteJson(route('admin.layout.destroy', [$layout->first()]))
            ->assertOk();

        $this->assertDatabaseCount(Layout::Table(), 4);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        Layout::factory(15)->create();
        $this->getJson(route('admin.layout.index'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
