<?php

namespace Domain\Accounts\Mail;


use Support\Contracts\Mail\AbstractSendUsingMessageTemplateSystemId;

class MembershipAutoRenewalFailed extends AbstractSendUsingMessageTemplateSystemId
{
    public function messageTemplateSystemId(): string
    {
        return "membership-auto-renewal-failed";
    }
}
