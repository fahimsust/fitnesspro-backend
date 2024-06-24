<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SiteCategoryFilterControllerTest extends ControllerTestCase
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
    public function can_update_cart_allowavailability()
    {

        $this->postJson(
            route('admin.site.category-filter.store', $this->site),
            [
                'filter_categories' => 2,
            ]
        )
            ->assertCreated()
            ->assertJsonStructure([
                'filter_categories',
            ]);
        $this->assertEquals(2, SiteSettings::first()->filter_categories);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.site.category-filter.store', $this->site), [
            'filter_categories' => 3,
        ])
            ->assertJsonValidationErrorFor('filter_categories')
            ->assertStatus(422);
    }
    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.site.category-filter.store', $this->site),
            [
                'filter_categories' => 2,
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
