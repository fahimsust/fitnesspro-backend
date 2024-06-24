<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Sites\Actions\Offline\UpdateOfflineSettings;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OfflineSettingsControllerTest extends ControllerTestCase
{

    public Layout $layout;
    public Site $site;
    public SiteSettings $settings;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create();
        $this->settings = SiteSettings::factory()->create();
        $this->layout = Layout::factory()->create();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_offline_setting()
    {
        $this->postJson(route('admin.site.offline-settings.store', [$this->site]), ["offline_message" => "Test", "offline_layout_id" => $this->layout->id])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('Test', $this->site->refresh()->offline_message);
        $this->assertEquals($this->layout->id, $this->settings->refresh()->offline_layout_id);
    }

    /** @test */
    public function can_get_offline_setting()
    {
        $this->getJson(route('admin.site.offline-settings.index', [$this->site]))
            ->assertOk()
            ->assertJsonStructure(['offline_message', 'offline_layout_id']);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.site.offline-settings.store', [$this->site]), ["offline_message" => "", "offline_layout_id" => $this->layout->id])
            ->assertJsonValidationErrorFor('offline_message')
            ->assertStatus(422);
        $this->assertNotEquals('Test', $this->site->refresh()->offline_message);
        $this->assertNotEquals($this->layout->id, $this->settings->refresh()->offline_layout_id);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateOfflineSettings::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.site.offline-settings.store', [$this->site]), ["offline_message" => "Test", "offline_layout_id" => $this->layout->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertNotEquals('Test', $this->site->refresh()->offline_message);
        $this->assertNotEquals($this->layout->id, $this->settings->refresh()->offline_layout_id);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        $this->postJson(route('admin.site.offline-settings.store', [$this->site]), ["offline_message" => "Test", "offline_layout_id" => $this->layout->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertNotEquals('Test', $this->site->refresh()->offline_message);
        $this->assertNotEquals($this->layout->id, $this->settings->refresh()->offline_layout_id);
    }
}
