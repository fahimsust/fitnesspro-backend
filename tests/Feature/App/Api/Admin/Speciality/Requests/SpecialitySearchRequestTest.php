<?php

namespace Tests\Feature\App\Api\Admin\Speciality\Requests;

use App\Api\Admin\Speciality\Requests\SpecialitySearchRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SpecialitySearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SpecialitySearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SpecialitySearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'keyword' => ['string', 'nullable'],
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
