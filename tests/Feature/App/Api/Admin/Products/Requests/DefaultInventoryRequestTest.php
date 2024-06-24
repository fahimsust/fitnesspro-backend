<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\DefaultInventoryRequest;
use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Domain\Products\Models\Product\ProductAvailability;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class DefaultInventoryRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private DefaultInventoryRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new DefaultInventoryRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'default_outofstockstatus_id' => [
                    'int',
                    'exists:' . ProductAvailability::Table() . ',id',
                    'nullable',
                ],
                'default_distributor_id' => [
                    'int',
                    'exists:' . Distributor::Table() . ',id',
                    'nullable',
                ],
                'fulfillment_rule_id' => [
                    'int',
                    'exists:' . FulfillmentRule::Table() . ',id',
                    'nullable',
                ],
                'default_cost' => ['numeric','nullable'],
                'inventoried' => ['bool','nullable']
            ],
            $this->request->rules()
        );
    }

    /** @test */
    public function can_authorize()
    {
        $this->createAndAuthAdminUser();

        $this->assertTrue($this->request->authorize());
    }
}
