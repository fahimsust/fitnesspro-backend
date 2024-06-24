<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ArchiveProductRequest;
use Domain\Products\Models\Product\Product;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;


class ArchiveProductRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ArchiveProductRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ArchiveProductRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'product_id' => [
                    'int',
                    Rule::exists(Product::Table(),'id')->where(function ($query) {
                        return $query->whereNotNull('deleted_at');
                    }),
                    'required'
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
