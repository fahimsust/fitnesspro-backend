<?php

namespace Tests\Feature\App\Api\Admin\Faqs\Requests;

use App\Api\Admin\Faqs\Requests\FaqCategoresRequest;
use Domain\Content\Models\Faqs\FaqCategory;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class FaqCategoriesRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private FaqCategoresRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FaqCategoresRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'categories_id' => ['numeric', 'exists:' . FaqCategory::Table() . ',id', 'required'],
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
