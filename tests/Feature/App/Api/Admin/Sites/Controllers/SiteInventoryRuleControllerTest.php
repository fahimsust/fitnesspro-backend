<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Sites\Actions\InventoryRules\AddInventoryRuleToSite;
use Domain\Sites\Models\InventoryRule;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteInventoryRule;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SiteInventoryRuleControllerTest extends ControllerTestCase
{
    public Site $site;
    public InventoryRule $inventoryRule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->site = Site::factory()->create();
        $this->inventoryRule = InventoryRule::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_remove_inventory_rule_from_site()
    {
        SiteInventoryRule::factory()->create();

        $this->deleteJson(
            route('admin.site.inventory-rule.destroy', [$this->site,$this->inventoryRule])
        )->assertOk();

        $this->assertDatabaseCount(SiteInventoryRule::Table(), 0);
    }

    /** @test */
    public function can_get_inventory_rules()
    {
        SiteInventoryRule::factory()->create();
        $this->getJson(
            route('admin.site.inventory-rule.index', [$this->site])
        )->assertOk()->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'action',
                        'min_stock_qty',
                        'max_stock_qty',
                        'availabity_changeto',
                        'label'
                    ]
                ]
            )->assertJsonCount(1);
    }

    /** @test */
    public function can_add_inventory_rule_to_site()
    {
        $this->postJson(
            route('admin.site.inventory-rule.store', [$this->site]),
            [
                'rule_id' => $this->inventoryRule->id
            ]
        )->assertCreated()->assertJsonStructure(
                [
                    '*' => [
                        'site_id',
                        'rule_id'
                    ]
                ]
            );;
        $this->assertDatabaseCount(SiteInventoryRule::Table(), 1);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {

        $this->postJson(
            route('admin.site.inventory-rule.store', $this->site),
            [
                'rule_id' => 0
            ]
        )->assertJsonValidationErrorFor('rule_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(SiteInventoryRule::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AddInventoryRuleToSite::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(
            route('admin.site.inventory-rule.store', $this->site),
            [
                'rule_id' => $this->inventoryRule->id
            ]
        )->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(SiteInventoryRule::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(
            route('admin.site.inventory-rule.store', $this->site),
            [
                'rule_id' => $this->inventoryRule->id
            ]
        )->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(SiteInventoryRule::Table(), 0);
    }
}
