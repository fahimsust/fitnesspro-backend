<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Discounts\Models\Rule\Condition\ConditionDistributor;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Distributors\Models\Distributor;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DistributorsControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_distributors()
    {
        Distributor::factory(5)->create();

        $this->getJson(route('admin.distributors'))
            ->assertOk()
            ->assertJsonCount(5)
            ->assertJsonStructure(["*" => ['id', 'name']]);
    }

    /** @test */
    public function can_search_distributor_for_discount_condition()
    {
        $discountCondition = DiscountCondition::factory()->create();
        $distributors = Distributor::factory(10)->create();
        ConditionDistributor::factory()->create(['distributor_id' => $distributors[0]->id, 'condition_id' => $discountCondition->id]);
        ConditionDistributor::factory()->create(['distributor_id' => $distributors[1]->id, 'condition_id' => $discountCondition->id]);
        ConditionDistributor::factory()->create(['distributor_id' => $distributors[2]->id, 'condition_id' => $discountCondition->id]);
        $this->getJson(
            route('admin.distributors', ['condition_id' => $discountCondition->id]),
        )
            ->assertOk()
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'name',
                        'email'
                    ]
                ]
            )->assertJsonCount(7);
    }
}
