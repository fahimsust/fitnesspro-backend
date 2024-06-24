<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Requests;

use App\Api\Admin\ProductOptions\Requests\CreateProductOptionValueRequest;
use App\Api\Admin\ProductOptions\Requests\OptionValuesSearchRequest;
use Domain\Products\Models\Product\Option\ProductOption;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class OptionValuesSearchRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private OptionValuesSearchRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new OptionValuesSearchRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'keyword' => ['string', 'nullable'],
                'start_date' => ['date', 'nullable'],
                'end_date' => ['date', 'after:start_date', 'nullable'],
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
