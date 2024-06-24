<?php

namespace Tests\Feature\App\Api\Admin\Products\Requests;

use App\Api\Admin\Products\Requests\ProductFormRequest;
use App\Rules\IsCompositeUnique;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductForm;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

class ProductFormRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private ProductFormRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ProductFormRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'form_id' => [
                    'int',
                    'exists:' . CustomForm::Table() . ',id',
                    'required'
                ],
                'rank' => ['int', 'nullable'],
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
