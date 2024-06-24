<?php

namespace Tests\Feature\App\Api\Admin\Currency\Controllers;

use Domain\Locales\Models\Currency;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteCurrency;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CurrencyControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_currency_list()
    {
        Currency::factory(30)->create();

        $this->getJson(route('admin.currency.index'))
            ->assertOk()
            ->assertJsonStructure([ '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(30);
    }
    /** @test */
    public function can_search_currency_for_site()
    {
        $site = Site::factory()->create();
        $currencies = Currency::factory(10)->create();
        SiteCurrency::factory()->create(['currency_id' => $currencies[0]->id,'site_id'=>$site->id]);
        SiteCurrency::factory()->create(['currency_id' => $currencies[1]->id,'site_id'=>$site->id]);
        SiteCurrency::factory()->create(['currency_id' => $currencies[2]->id,'site_id'=>$site->id]);
        $this->getJson(
            route('admin.currency.index', ['site_id' => $site->id]),
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])->assertJsonCount(7);
    }
}
