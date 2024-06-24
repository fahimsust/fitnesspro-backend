<?php

namespace Tests\Unit\Domain\Messaging\Models;

use Domain\Locales\Models\Language;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Messaging\Models\MessageTemplateTranslation;
use Tests\UnitTestCase;

class MessageTemplateTranslationTest extends UnitTestCase
{
    private MessageTemplateTranslation $messageTemplateTranslation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->messageTemplateTranslation = MessageTemplateTranslation::factory()->create();
    }

    /** @test */
    public function can_get_message_template()
    {
        $this->assertInstanceOf(MessageTemplate::class, $this->messageTemplateTranslation->messageTemplate);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->messageTemplateTranslation->language);
    }
}
