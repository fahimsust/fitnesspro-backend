<?php

namespace Tests\Feature\App\Api\Admin\Layouts\Requests;

use App\Api\Admin\Brands\Requests\BrandRequest;
use App\Api\Admin\Layouts\Requests\LayoutRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class LayoutRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private LayoutRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new LayoutRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => $this->request->name_rule(),
                'file' => ['string', 'max:100', 'required']
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
