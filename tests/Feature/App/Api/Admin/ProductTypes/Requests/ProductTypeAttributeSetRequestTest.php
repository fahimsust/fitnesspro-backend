<?php

namespace Tests\Feature\App\Api\Admin\ProductTypes\Requests;

use App\Api\Admin\Products\Types\Requests\ProductTypeAttributeSetRequest;
use Domain\Products\Models\Attribute\AttributeSet;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class ProductTypeAttributeSetRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductTypeAttributeSetRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductTypeAttributeSetRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'set_ids' => [
                    'array',
                    'nullable'
                ],
                'set_ids.*' => [
                    'int',
                    'exists:' . AttributeSet::Table() . ',id',
                    'nullable'
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
