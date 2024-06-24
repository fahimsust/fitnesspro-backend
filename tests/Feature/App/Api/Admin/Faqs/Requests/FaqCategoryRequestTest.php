<?php

namespace Tests\Feature\App\Api\Admin\Faqs\Requests;

use App\Api\Admin\Faqs\Requests\FaqCategoryRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class FaqCategoryRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private FaqCategoryRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FaqCategoryRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => $this->request->titleRule(),
                'url' => $this->request->urlRule(),
                'status' => ['boolean','required'],
                'rank' => ['int', 'required'],
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
