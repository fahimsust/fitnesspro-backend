<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\DistributorsInventoryRequest;
use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Product\ProductAvailability;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class DistributorsInventoryRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private DistributorsInventoryRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new DistributorsInventoryRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'outofstockstatus_id' => [
                    'int',
                    'exists:' . ProductAvailability::Table() . ',id',
                    'nullable',
                ],
                'distributor_id' => [
                    'int',
                    'exists:' . Distributor::Table() . ',id',
                    'nullable',
                ],
                'stock_qty' => ['numeric','nullable'],
                'cost' => ['numeric','nullable'],
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
