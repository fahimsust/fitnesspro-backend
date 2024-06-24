<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Requests;

use App\Api\Admin\Attributes\Requests\AttributeUpdateRequest;
use Domain\Products\Models\Attribute\AttributeType;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AttributeUpdateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AttributeUpdateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AttributeUpdateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:55','required'],
                'type_id' => ['numeric', 'exists:' . AttributeType::Table() . ',id', 'required'],
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
