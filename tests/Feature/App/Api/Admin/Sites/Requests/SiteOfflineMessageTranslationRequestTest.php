<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\SiteOfflineMessageTranslationRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SiteOfflineMessageTranslationRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SiteOfflineMessageTranslationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SiteOfflineMessageTranslationRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'offline_message' => ['string', 'required'],
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
