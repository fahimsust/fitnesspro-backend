<?php

namespace Tests\Feature\App\Api\Admin\Faqs\Requests;

use App\Api\Admin\Faqs\Requests\FaqCategoryTranslationRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class FaqCategoryTranslationRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private FaqCategoryTranslationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FaqCategoryTranslationRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => ['string','max:255', 'required']
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
