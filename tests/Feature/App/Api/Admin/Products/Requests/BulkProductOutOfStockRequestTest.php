<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\BulkProductOutOfStockRequest;
use App\Api\Admin\Products\Requests\BulkProductRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class BulkProductOutOfStockRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private BulkProductOutOfStockRequest $request;
    private BulkProductRequest $parentRequest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new BulkProductOutOfStockRequest();
        $this->parentRequest = new BulkProductRequest();
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
