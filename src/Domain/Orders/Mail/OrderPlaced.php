<?php

namespace Domain\Orders\Mail;

use Support\Contracts\Mail\AbstractSendUsingMessageTemplateSystemId;

class OrderPlaced extends AbstractSendUsingMessageTemplateSystemId
{
    public function messageTemplateSystemId(): string
    {
        return "1";
    }
}
