<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Sites\Actions\Offline\TakeSiteOnline;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OfflineOnlineControllerTest extends ControllerTestCase
{
    public Site $site;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create(['offline_key' => null]);
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_take_site_offline()
    {
        $this->assertNull($this->site->offline_key);

        $this->deleteJson(route('admin.site.offline', $this->site))
            ->assertOk()
            ->assertJsonStructure(['id']);

        $this->assertFalse($this->site->refresh()->status);
        $this->assertNotNull($this->site->fresh()->offline_key);
    }

    /** @test */
    public function can_take_site_online()
    {
        $this->postJson(route('admin.site.online', $this->site))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertTrue($this->site->refresh()->status);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(TakeSiteOnline::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.site.online', [$this->site]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertFalse($this->site->refresh()->status);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.site.online', $this->site))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertFalse($this->site->refresh()->status);
    }
}
