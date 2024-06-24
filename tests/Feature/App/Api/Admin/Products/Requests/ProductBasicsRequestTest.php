<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductBasicsRequest;
use Domain\Distributors\Models\Distributor;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductBasicsRequestTest extends ControllerTestCase
{
    use AdditionalAssertions;

    private ProductBasicsRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductBasicsRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'title' => ['string', 'required'],
                'subtitle' => ['string', 'max:255', 'nullable'],
                'url_name' => $this->request->urlRule(),
                'default_distributor_id' => [
                    'int',
                    'exists:' . Distributor::Table() . ',id',
                    'nullable',
                ],
                'product_no' => ['string', 'max:155', 'nullable'],
                'weight' => ['int', 'nullable']
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
