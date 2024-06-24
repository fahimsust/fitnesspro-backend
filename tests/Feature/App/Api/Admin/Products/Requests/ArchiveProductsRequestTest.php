<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ArchiveProductsRequest;
use Domain\Products\Models\Product\Product;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;


class ArchiveProductsRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ArchiveProductsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ArchiveProductsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'product_ids' => [
                    'array',
                    'required'
                ],
                'product_ids.*' => [
                    'int',
                    Rule::exists(Product::Table(),'id')->where(function ($query) {
                        return $query->whereNotNull('deleted_at');
                    }),
                ]
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
