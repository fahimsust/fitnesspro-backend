<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Locales\Models\Currency;
use Domain\Sites\Actions\Currencies\ActivateCurrencyForSite;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteCurrency;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SiteCurrencyControllerTest extends ControllerTestCase
{

    public Currency $currency;
    public Site $site;
    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->currency = Currency::factory()->create();
        $this->site = Site::factory()->create();
    }

    /** @test */
    public function can_add_currency_in_site()
    {
        $this->postJson(route('admin.site.currency.store', $this->site), ["currency_id" => $this->currency->id])
            ->assertCreated()
            ->assertJsonStructure(['currency_id', 'site_id']);

        $this->assertDatabaseCount(SiteCurrency::Table(), 1);
    }
    /** @test */
    public function can_update_rank()
    {
        SiteCurrency::factory()->create();
        $this->putJson(
            route('admin.site.currency.update', [$this->site, $this->currency->id]),
            ["rank" => 5]
        )
            ->assertCreated();

        $this->assertEquals(5, SiteCurrency::first()->rank);
    }

    /** @test */
    public function can_delete_currency_from_site()
    {
        SiteCurrency::factory()->create();

        $this->deleteJson(
            route('admin.site.currency.destroy', [$this->site, $this->currency]),
        )->assertOk();

        $this->assertDatabaseCount(SiteCurrency::Table(), 0);
    }

    /** @test */
    public function can_get_currency_in_site()
    {
        SiteCurrency::factory()->create();

        $this->getJson(route('admin.site.currency.index', $this->site))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'name']]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.site.currency.store', $this->site), ["currency_id" => 0])
            ->assertJsonValidationErrorFor('currency_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(SiteCurrency::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(ActivateCurrencyForSite::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.site.currency.store', $this->site), ["currency_id" => $this->currency->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(SiteCurrency::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.site.currency.store', $this->site), ["currency_id" => $this->currency->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(SiteCurrency::Table(), 0);
    }
}
