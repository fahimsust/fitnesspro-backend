<?php

namespace Tests\Feature\App\Api\Admin\MessageTemplates\Controllers;

use App\Api\Admin\MessageTemplates\Requests\MessageTemplateTranslationRequest;
use Domain\Locales\Models\Language;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Messaging\Models\MessageTemplateTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class MessageTemplateTranslationControllerTest extends ControllerTestCase
{
    private MessageTemplate $messageTemplate;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->messageTemplate = MessageTemplate::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_message_template_translation()
    {
        MessageTemplateTranslationRequest::fake();
        $this->putJson(
            route('admin.message-template.translation.update', [$this->messageTemplate, $this->language->id])
        )
            ->assertCreated()
            ->assertJsonStructure(['id', 'subject', 'alt_body', 'html_body']);

        $this->assertDatabaseCount(MessageTemplateTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_message_template_translation()
    {
        MessageTemplateTranslation::factory()->create();
        MessageTemplateTranslationRequest::fake(['subject' => 'test subject', 'html_body' => 'test content']);

        $this->putJson(route('admin.message-template.translation.update', [$this->messageTemplate, $this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(MessageTemplateTranslation::Table(), ['subject' => 'test subject', 'html_body' => 'test content']);
    }
    /** @test */
    public function can_get_message_template_translation()
    {
        MessageTemplateTranslation::factory()->create();
        $this->getJson(route('admin.message-template.translation.show', [$this->messageTemplate, $this->language->id]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'id',
                ]
            );
    }


    /** @test */
    public function can_validate_request_and_return_errors()
    {
        MessageTemplateTranslationRequest::fake(['subject' => '']);

        $this->putJson(route('admin.message-template.translation.update', [$this->messageTemplate, $this->language->id]))
            ->assertJsonValidationErrorFor('subject')
            ->assertStatus(422);

        $this->assertDatabaseCount(MessageTemplateTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        MessageTemplateTranslationRequest::fake();

        $this->putJson(route('admin.message-template.translation.update', [$this->messageTemplate, $this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(MessageTemplateTranslation::Table(), 0);
    }
}
