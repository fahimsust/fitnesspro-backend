<?php

namespace Tests\Feature\App\Api\Admin\InventoryRules\Controllers;

use Domain\Sites\Models\InventoryRule;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteInventoryRule;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class InventoryRuleControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }


    /** @test */
    public function can_get_brands_list()
    {
        InventoryRule::factory(30)->create();

        $this->getJson(route('admin.inventory-rule.index'))
            ->assertOk()
            ->assertJsonStructure([ '*' => [
                    'id',
                    'label',
                ]
            ])
            ->assertJsonCount(30);
    }
    /** @test */
    public function can_search_language_for_site()
    {
        $site = Site::factory()->create();
        $rules = InventoryRule::factory(10)->create();
        SiteInventoryRule::factory()->create(['rule_id' => $rules[0]->id,'site_id'=>$site->id]);
        $this->getJson(
            route('admin.inventory-rule.index', ['site_id' => $site->id]),
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'label',
                ]
            ])->assertJsonCount(9);
    }
}
