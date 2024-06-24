<?php

namespace Tests\Feature\App\Api\Admin\Elements\Requests;

use App\Api\Admin\Elements\Requests\ElementRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ElementRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ElementRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ElementRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => ['string','max:155', 'required'],
                'notes' => ['string', 'max:100', 'nullable'],
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
