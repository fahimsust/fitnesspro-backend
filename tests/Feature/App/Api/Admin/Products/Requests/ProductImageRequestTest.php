<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductImageRequest;
use App\Rules\IsCompositeUnique;
use Domain\Content\Models\Image;
use Domain\Products\Models\Product\ProductImage;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductImageRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductImageRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductImageRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'image_id'=>['int','exists:' . Image::Table() . ',id', 'required',new IsCompositeUnique(ProductImage::Table(),['image_id'=>$this->request->image_id,'product_id'=>$this->request->product_id],$this->request->id)],
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
