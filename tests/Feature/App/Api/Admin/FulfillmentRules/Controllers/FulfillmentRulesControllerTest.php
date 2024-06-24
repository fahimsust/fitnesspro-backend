<?php

namespace Tests\Feature\App\Api\Admin\FulfillmentRules\Controllers;

use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FulfillmentRulesControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }


    /** @test */
    public function can_get_all_fulfillment_rules()
    {
        FulfillmentRule::factory(30)->create(['status'=>1]);

        $this->getJson(route('admin.ful-fillment-rules.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'any_all'
                ]
            ])->assertJsonCount(30);
    }


}
