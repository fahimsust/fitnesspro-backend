<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryMetaDataRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategoryMetaDataRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryMetaDataRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new CategoryMetaDataRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'meta_title' => ['string','max:200', 'nullable'],
                'meta_desc' => ['string','max:255', 'nullable'],
                'meta_keywords' => ['string','max:255', 'nullable']
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
