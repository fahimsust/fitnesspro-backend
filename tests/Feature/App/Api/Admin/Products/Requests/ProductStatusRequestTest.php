<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductStatusRequest;
use Illuminate\Validation\Rule;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductStatusRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductStatusRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductStatusRequest();
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
                ],
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
