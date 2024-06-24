<?php

namespace Tests\Unit\Domain\Messaging\Models;

use Database\Seeders\MessageTemplateSeeder;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Messaging\Models\MessageTemplateTranslation;
use Tests\UnitTestCase;

class MessageTemplateTest extends UnitTestCase
{
    protected $forgotUserTemplate;
    private MessageTemplateTranslation $messageTemplateTranslation;

    /** @test */
    public function can_find_by_system_id()
    {
        $this->assertEquals('Customer Account - Forgot Username', $this->forgotUserTemplate->name);
    }

    /** @test */
    public function html_tags_are_decoded()
    {
        $htmlContent = $this->forgotUserTemplate->html;

        $this->assertTrue($this->isHtml($htmlContent));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(MessageTemplateSeeder::class);

        $this->forgotUserTemplate = MessageTemplate::FindBySystemId('forgot_username');
    }
    public function can_get_element_translations()
    {
        $this->assertInstanceOf(MessageTemplateTranslation::class, $this->messageTemplateTranslation->translations()->first());
    }
}
