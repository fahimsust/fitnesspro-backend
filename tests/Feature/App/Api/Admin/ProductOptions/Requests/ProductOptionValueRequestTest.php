<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Requests;

use App\Api\Admin\ProductOptions\Requests\CreateProductOptionValueRequest;
use Domain\Products\Models\Product\Option\ProductOption;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductOptionValueRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CreateProductOptionValueRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CreateProductOptionValueRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'display' => ['string', 'max:100', 'required'],
                'rank' => ['numeric', 'required'],
                'option_id' => ['numeric', 'exists:' . ProductOption::Table() . ',id', 'required'],
                'price' => ['numeric', 'required'],
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
