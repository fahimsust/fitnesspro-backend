<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\SiteCurrencyRankRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SiteCurrencyRankRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SiteCurrencyRankRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new SiteCurrencyRankRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'rank' => ['numeric', 'required'],
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
