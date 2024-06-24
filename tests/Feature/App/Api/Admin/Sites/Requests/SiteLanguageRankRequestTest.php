<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\SiteLanguageRankRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SiteLanguageRankRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SiteLanguageRankRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new SiteLanguageRankRequest();
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
