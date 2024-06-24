<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\CreateSiteRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CreateSiteRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateSiteRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateSiteRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string','max:55', 'required'],
                'domain' => ['string', 'max:65', 'nullable'],
                'email' => ['email', 'max:85', 'required'],
                'phone' => ['string', 'max:20', 'required'],
                'url' => ['string', 'max:255', 'required'],
                'meta_title' => ['string', 'max:255', 'required'],
                'meta_keywords' => ['string', 'max:255', 'required'],
                'meta_desc' => ['string', 'max:255', 'required'],
                'logo_url'=>['string', 'max:255', 'nullable'],
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
