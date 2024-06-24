<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\AllowOrderingOfRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;


class AllowOrderingOfRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private AllowOrderingOfRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AllowOrderingOfRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'cart_allowavailability' => ['array', 'nullable'],
                'cart_orderonlyavailableqty' => ['boolean', 'required'],
                'cart_addtoaction' => ['int', 'required', Rule::in([0, 1]),],
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
