<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class AllowOrderingOfControllerTest extends ControllerTestCase
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
        $this->withoutExceptionHandling();

        $this->postJson(
            route('admin.site.allow-ordering.store', $this->site),
            [
                'cart_allowavailability' => [3, 4],
                'cart_orderonlyavailableqty' => true,
                'cart_addtoaction' => 1

            ]
        )
            ->assertCreated()
            ->assertJsonStructure([
                'cart_allowavailability',
                'cart_orderonlyavailableqty',
                'cart_addtoaction'
            ]);
        $this->assertEquals([3, 4], SiteSettings::first()->cart_allowavailability->toArray());
        $this->assertTrue(SiteSettings::first()->cart_orderonlyavailableqty);
        $this->assertEquals(1, SiteSettings::first()->cart_addtoaction);
    }

    /** @test */
    public function can_get_cart_allowavailability()
    {
        $this->withoutExceptionHandling();
        $this->getJson(route('admin.site.allow-ordering.index', $this->site))
            ->assertOk()
            ->assertJsonStructure([
                'cart_allowavailability',
                'cart_orderonlyavailableqty',
                'cart_addtoaction'
            ]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.site.allow-ordering.store', $this->site), [
            'cart_allowavailability' => 'test',
            'cart_orderonlyavailableqty' => true,
            'cart_addtoaction' => 1
        ])
            ->assertJsonValidationErrorFor('cart_allowavailability')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.site.allow-ordering.store', $this->site), [
            'cart_allowavailability' => [3, 4],
            'cart_orderonlyavailableqty' => true,
            'cart_addtoaction' => 1
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
