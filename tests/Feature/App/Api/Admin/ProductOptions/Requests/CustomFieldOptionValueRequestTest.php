<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Requests;

use App\Api\Admin\ProductOptions\Requests\CustomFieldOptionValueRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CustomFieldOptionValueRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CustomFieldOptionValueRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CustomFieldOptionValueRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'custom_type' => ['numeric', 'required'],
                'custom_charlimit' => ['numeric', 'required'],
                'custom_label' => ['string', 'max:35', 'required'],
                'custom_instruction' => ['string', 'max:255', 'required'],
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
