<?php

namespace Tests\Feature\App\Api\Admin\ProductTypes\Controllers;

use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Tests\Feature\Traits\TestProductTypeAttribute;

use function route;

class ProductTypeAttributesControllerTest extends ControllerTestCase
{
    use TestProductTypeAttribute;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->createProductTypeAttributeWithOption();
    }

    /** @test */
    public function can_get_all_the_attributes_for_product_type()
    {

        $this->getJson(route('admin.product-type.attributes', $this->productType))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'attribute_sets' => [
                        '*' =>
                        [
                            'attributes' => [
                                '*' => ['options']
                            ]
                        ]
                    ]
                ]
            )->assertJsonCount(5,'attribute_sets');
    }
}
