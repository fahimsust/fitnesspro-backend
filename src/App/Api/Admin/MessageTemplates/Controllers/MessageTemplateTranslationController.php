<?php

namespace App\Api\Admin\MessageTemplates\Controllers;

use App\Api\Admin\MessageTemplates\Requests\MessageTemplateTranslationRequest;
use Domain\Messaging\Models\MessageTemplate;
use Domain\Messaging\Models\MessageTemplateTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MessageTemplateTranslationController extends AbstractController
{
    public function update(MessageTemplate $messageTemplate, int $language_id, MessageTemplateTranslationRequest $request)
    {
        return response(
            $messageTemplate->translations()->updateOrCreate(
                [
                    'language_id' => $language_id
                ],
                [
                    'subject' => $request->subject,
                    'alt_body' => $request->alt_body,
                    'html_body' => $request->html_body,
                ]
            ),
            Response::HTTP_CREATED
        );
    }

    public function show(int $message_template_id, int $language_id)
    {
        return response(
            MessageTemplateTranslation::where('message_template_id', $message_template_id)->where('language_id', $language_id)->first(),
            Response::HTTP_OK
        );
    }
}
