<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;


use App\Api\Admin\Sites\Requests\SiteMessageTemplateRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SiteMessageTemplateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SiteMessageTemplateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SiteMessageTemplateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'html' => ['string', 'required'],
                'alt' => ['string', 'nullable']
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
