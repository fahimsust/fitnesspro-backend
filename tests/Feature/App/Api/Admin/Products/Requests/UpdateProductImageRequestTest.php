<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\UpdateProductImageRequest;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class UpdateProductImageRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private UpdateProductImageRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new UpdateProductImageRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'caption' => ['string','max:55', 'nullable'],
                'rank' => ['int', 'nullable'],
                'show_in_gallery' => ['bool', 'nullable']
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
