<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\BulkProductImageRequest;
use App\Api\Admin\Products\Requests\BulkProductRequest;
use Domain\Content\Models\Image;
use Domain\Products\Models\Product\Product;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class BulkProductRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private BulkProductRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new BulkProductRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'products' => [
                    'array',
                    'required'
                ],
                'products.*' => [
                    'int',
                    'exists:' . Product::Table() . ',id',
                    'required'
                ],
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
