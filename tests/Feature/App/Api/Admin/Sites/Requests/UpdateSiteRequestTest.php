<?php

namespace Tests\Feature\App\Api\Admin\Sites\Requests;

use App\Api\Admin\Sites\Requests\UpdateSiteRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class UpdateSiteRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private UpdateSiteRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new UpdateSiteRequest();
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
