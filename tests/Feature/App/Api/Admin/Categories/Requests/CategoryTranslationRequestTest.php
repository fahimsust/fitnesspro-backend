<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryTranslationRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategoryTranslationRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryTranslationRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategoryTranslationRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => ['string','max:255', 'required'],
                'subtitle' => ['string', 'max:155', 'nullable'],
                'url_name' => $this->request->urlRule(),
                'description' => ['string','nullable'],
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
