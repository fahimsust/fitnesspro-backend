<?php

namespace Tests\Feature\App\Api\Admin\MessageTemplates\Requests;

use App\Api\Admin\MessageTemplates\Requests\MessageTemplateRequest;
use Domain\Messaging\Models\MessageTemplateCategory;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;


class MessageTemplateRequestTest extends ControllerTestCase
{
    use  AdditionalAssertions;

    private MessageTemplateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new MessageTemplateRequest();
    }

    /** @test */
    public function has_expected_rules()
    {
        $this->assertEquals(
            [
                'name' => ['string', 'max:55', 'required'],
                'subject' => ['string', 'max:255', 'required'],
                'alt_body' => ['string', 'required'],
                'html_body' => ['string', 'required'],
                'note' => ['string', 'max:255', 'nullable'],
                'system_id' => ['string', 'max:85', 'nullable'],
                'category_id' => ['numeric', 'exists:' . MessageTemplateCategory::Table() . ',id', 'nullable'],
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
