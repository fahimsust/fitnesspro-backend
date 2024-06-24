<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\BulkProductDistributorRequest;
use App\Api\Admin\Products\Requests\BulkProductRequest;
use Domain\Distributors\Models\Distributor;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class BulkProductDistributorRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private BulkProductDistributorRequest $request;
    private BulkProductRequest $parentRequest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new BulkProductDistributorRequest();
        $this->parentRequest = new BulkProductRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'default_distributor_id' => [
                    'int',
                    'exists:' . Distributor::Table() . ',id',
                    'required',
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
