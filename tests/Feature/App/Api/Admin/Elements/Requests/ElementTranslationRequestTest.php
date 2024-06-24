<?php

namespace Tests\Feature\App\Api\Admin\Elements\Requests;

use App\Api\Admin\Elements\Requests\ElementTranslationRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ElementTranslationRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ElementTranslationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ElementTranslationRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'element_content' => ['string', 'nullable'],
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
