<?php

namespace Tests\Feature\App\Api\Admin\Pages\Requests;

use App\Api\Admin\Pages\Requests\PageRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class PageRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private PageRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new PageRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => ['string','max:255', 'required'],
                'url_name' => $this->request->urlRule(),
                'page_content' => ['string', 'nullable'],
                'notes' => ['string', 'max:100', 'nullable'],
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
