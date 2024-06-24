<?php

namespace Tests\Feature\App\Api\Admin\CustomForms\Requests;

use App\Api\Admin\CustomForms\Requests\CustomFieldRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;


class CustomFieldRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CustomFieldRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CustomFieldRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:255', 'required'],
                'display' => ['string','max:255', 'required'],
                'required' => ['bool', 'required'],
                'status' => ['bool', 'required'],
                'type' => ['int', 'required',Rule::in([0,1,2,3,4,5,6])],
                'specs' => ['int', 'nullable',Rule::in([1,2,3])]
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
