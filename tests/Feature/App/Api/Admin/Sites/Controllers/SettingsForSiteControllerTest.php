<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SettingsForSiteRequest;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SettingsForSiteControllerTest extends ControllerTestCase
{
    public Site $site;
    public SiteSettings $settings;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create();
        $this->settings = SiteSettings::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_setting()
    {
        SettingsForSiteRequest::fake([
            'home_show_categories_in_body' => true,
            'home_feature_show' => false
        ]);

        $this->withoutExceptionHandling();

        $this->postJson(route('admin.site.settings.store', $this->site))
            ->assertCreated()
            ->assertJsonStructure(
                [
                    'home_show_categories_in_body',
                    'home_feature_show',
                    'catalog_show_categories_in_body',
                    'catalog_feature_show',
                    'default_show_categories_in_body',
                    'cart_orderonlyavailableqty'
                ]
            );

        $this->assertTrue($this->settings->refresh()->home_show_categories_in_body);
        $this->assertFalse($this->settings->refresh()->home_feature_show);
    }

    /** @test */
    public function can_get_setting()
    {
        $this->getJson(route('admin.site.settings.index', $this->site))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'home_show_categories_in_body',
                    'home_feature_show',
                    'catalog_show_categories_in_body',
                    'catalog_feature_show',
                    'default_show_categories_in_body',
                    'cart_orderonlyavailableqty'
                ]
            );
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        SettingsForSiteRequest::factory()->create(['home_show_categories_in_body' => 5]);

        $this->postJson(route('admin.site.settings.store', $this->site))
            ->assertJsonValidationErrorFor('home_show_categories_in_body')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();
        SettingsForSiteRequest::fake();

        $this->postJson(route('admin.site.settings.store', $this->site))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
