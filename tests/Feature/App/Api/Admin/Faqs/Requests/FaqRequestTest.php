<?php

namespace Tests\Feature\App\Api\Admin\Faqs\Requests;

use App\Api\Admin\Faqs\Requests\FaqRequest;
use Domain\Content\Models\Faqs\FaqCategory;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use Illuminate\Validation\Rule;


class FaqRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private FaqRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FaqRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'question' => ['string','max:255', 'required'],
                'url' => $this->request->urlRule(),
                'categories_id' => [
                    'array',
                    'required',
                ],
                'categories_id.*' => [
                    'int',
                    Rule::exists(FaqCategory::Table(), 'id'),
                ],
                'answer' => ['string','required'],
                'status' => ['boolean','required'],
                'rank' => ['int', 'required'],
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
