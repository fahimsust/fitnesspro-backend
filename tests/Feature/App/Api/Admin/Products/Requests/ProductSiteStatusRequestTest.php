<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductSiteStatusRequest;
use Domain\Sites\Models\Site;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductSiteStatusRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductSiteStatusRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductSiteStatusRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'site_id' => [
                    'int',
                    'exists:' . Site::Table() . ',id',
                    'nullable'
                ],
                'status' =>['bool','required']
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
