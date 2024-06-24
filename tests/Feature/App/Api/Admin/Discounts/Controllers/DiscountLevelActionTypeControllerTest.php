<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Enums\DiscountLevelActionType;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DiscountLevelActionTypeControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }


    /** @test */
    public function can_get_discount_level_action_types()
    {
        $this->getJson(route('admin.discount-level-action-type'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(count(DiscountLevelActionType::cases()));
    }
}
