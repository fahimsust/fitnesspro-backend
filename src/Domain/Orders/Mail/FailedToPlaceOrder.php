<?php

namespace Domain\Orders\Mail;

use Support\Contracts\Mail\AbstractSendUsingMessageTemplateSystemId;

class FailedToPlaceOrder extends AbstractSendUsingMessageTemplateSystemId
{
    public function messageTemplateSystemId(): string
    {
        return "failed-to-place-order";
    }
}
