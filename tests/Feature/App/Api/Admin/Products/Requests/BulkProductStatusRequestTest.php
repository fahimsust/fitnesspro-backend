<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\BulkProductStatusRequest;
use App\Api\Admin\Products\Requests\BulkProductRequest;
use Domain\Products\Models\Product\Product;
use Illuminate\Validation\Rule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class BulkProductStatusRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private BulkProductStatusRequest $request;
    private BulkProductRequest $parentRequest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new BulkProductStatusRequest();
        $this->parentRequest = new BulkProductRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'status' => [
                    'int',
                    'required',
                    Rule::in(['1','-1','0'])
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
