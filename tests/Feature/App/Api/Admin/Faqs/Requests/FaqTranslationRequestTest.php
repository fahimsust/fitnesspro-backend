<?php

namespace Tests\Feature\App\Api\Admin\Faqs\Requests;

use App\Api\Admin\Faqs\Requests\FaqTranslationRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class FaqTranslationRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private FaqTranslationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FaqTranslationRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'question' => ['string','max:255', 'required'],
                'answer' => ['string','required']
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
