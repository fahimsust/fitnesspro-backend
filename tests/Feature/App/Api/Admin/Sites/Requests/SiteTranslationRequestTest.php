<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\SiteTranslationRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class SiteTranslationRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private SiteTranslationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SiteTranslationRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'meta_title' => ['string', 'max:255', 'required'],
                'meta_keywords' => ['string', 'max:255', 'required'],
                'meta_desc' => ['string', 'max:255', 'required'],
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
