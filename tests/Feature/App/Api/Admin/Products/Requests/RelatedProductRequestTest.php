<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\RelatedProductRequest;
use App\Rules\IsCompositeUnique;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductRelated;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class RelatedProductRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private RelatedProductRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new RelatedProductRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(

            [
                'related_id' => [
                    'int',
                    'exists:' . Product::Table() . ',id',
                    'required',
                    new IsCompositeUnique(
                        ProductRelated::Table(),
                        [
                            'related_id' => $this->request->related_id,
                            'product_id' => $this->request->product_id
                        ],
                        $this->request->id
                    )
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
