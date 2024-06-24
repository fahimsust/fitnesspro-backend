<?php

namespace Tests\Feature\App\Api\Admin\Brands\Requests;

use App\Api\Admin\Brands\Requests\BrandRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class BrandRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private BrandRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new BrandRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => $this->request->name_rule(),
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
