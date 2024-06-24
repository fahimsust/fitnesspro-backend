<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\BulkProductDistributorStockQuantityRequest;
use App\Api\Admin\Products\Requests\BulkProductRequest;
use Domain\Distributors\Models\Distributor;
use Domain\Products\Models\Product\Product;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class BulkProductDistributorStockQuantityRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private BulkProductDistributorStockQuantityRequest $request;
    private BulkProductRequest $parentRequest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new BulkProductDistributorStockQuantityRequest();
        $this->parentRequest = new BulkProductRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'distributor_id' => [
                    'int',
                    'exists:' . Distributor::Table() . ',id',
                    'required'
                ],
                'stock_qty'=>[
                    'numeric',
                    'required'
                ]
            ]+$this->parentRequest->rules(),
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
