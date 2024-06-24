<?php

namespace Domain\Accounts\Mail;


use Support\Contracts\Mail\AbstractSendUsingMessageTemplateSystemId;

class UpdateCardExpirationForAutoRenewal extends AbstractSendUsingMessageTemplateSystemId
{
    public function messageTemplateSystemId(): string
    {
        return "update-auto-renew-card-expiration";
    }
}
