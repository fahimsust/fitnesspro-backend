<?php

namespace Tests\Feature\App\Api\Admin\Pages\Requests;

use App\Api\Admin\Pages\Requests\PageMetaDataRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class PageMetaDataRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private PageMetaDataRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new PageMetaDataRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'meta_title' => ['string','max:200', 'nullable'],
                'meta_description' => ['string','max:255', 'nullable'],
                'meta_keywords' => ['string','max:500', 'nullable']
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
