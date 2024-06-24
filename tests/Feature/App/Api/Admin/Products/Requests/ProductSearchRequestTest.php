<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductSearchRequest;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductType;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'keyword' => ['string', 'nullable'],
                'type_id' => ['int', 'exists:' . ProductType::Table() . ',id','nullable'],
                'product_id' => ['int', 'exists:' . Product::Table() . ',id','nullable'],
                'brand_id' => ['int', 'exists:' . Brand::Table() . ',id','nullable'],
                'hide_children' => ['bool', 'nullable'],
                'trashed' => ['bool', 'nullable'],
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
