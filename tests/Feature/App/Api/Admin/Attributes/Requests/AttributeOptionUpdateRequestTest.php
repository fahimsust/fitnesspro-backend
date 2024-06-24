<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Requests;

use App\Api\Admin\Attributes\Requests\AttributeOptionUpdateRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AttributeOptionUpdateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AttributeOptionUpdateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AttributeOptionUpdateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'display' => ['string','max:100','required'],
                'rank' => ['int','nullable'],
                'status' => ['bool','required'],
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
