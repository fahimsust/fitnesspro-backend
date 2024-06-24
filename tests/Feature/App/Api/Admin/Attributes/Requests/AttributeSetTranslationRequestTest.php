<?php

namespace Tests\Feature\App\Api\Admin\Attributes\Requests;

use App\Api\Admin\Attributes\Requests\AttributeSetTranslationRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class AttributeSetTranslationRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AttributeSetTranslationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AttributeSetTranslationRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:55','required'],
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
