<?php

namespace Tests\Feature\App\Api\Admin\Orders\Requests;

use App\Api\Admin\Orders\Requests\CreateOrderNoteRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateOrderNoteRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateOrderNoteRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateOrderNoteRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'note' => ['string', 'required']
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
