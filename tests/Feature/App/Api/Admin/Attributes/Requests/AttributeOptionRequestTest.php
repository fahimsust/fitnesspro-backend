<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Requests;

use App\Api\Admin\Attributes\Requests\AttributeOptionRequest;
use Domain\Products\Models\Attribute\Attribute;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AttributeOptionRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AttributeOptionRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AttributeOptionRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'display' => ['string','max:100','required'],
                'attribute_id' => ['numeric', 'exists:' . Attribute::Table() . ',id', 'required'],
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
