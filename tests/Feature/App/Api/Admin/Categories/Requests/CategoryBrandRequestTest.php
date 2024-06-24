<?php

namespace Tests\Feature\App\Api\Admin\Categories\Requests;

use App\Api\Admin\Categories\Requests\CategoryBrandRequest;
use Domain\Products\Models\Brand;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class CategoryBrandRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private CategoryBrandRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new CategoryBrandRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'brand_id' => ['numeric', 'exists:' . Brand::Table() . ',id', 'required'],
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
