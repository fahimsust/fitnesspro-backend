<?php

namespace Domain\Accounts\Mail;

use Support\Contracts\Mail\AbstractSendUsingMessageTemplateSystemId;

class MembershipHasBeenAutoRenewed extends AbstractSendUsingMessageTemplateSystemId
{
    public function messageTemplateSystemId(): string
    {
        return "membership-auto-renewed";
    }
}
