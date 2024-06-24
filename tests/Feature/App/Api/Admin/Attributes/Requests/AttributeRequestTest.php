<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Requests;

use App\Api\Admin\Attributes\Requests\AttributeRequest;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeType;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AttributeRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AttributeRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AttributeRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:55','required'],
                'type_id' => ['numeric', 'exists:' . AttributeType::Table() . ',id', 'required'],
                'set_id' => ['numeric', 'exists:' . AttributeSet::Table() . ',id', 'required'],
                'show_in_details' => ['bool','required'],
                'show_in_search' => ['bool','required'],
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
