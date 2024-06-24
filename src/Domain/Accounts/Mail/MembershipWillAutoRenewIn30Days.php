<?php

namespace Domain\Accounts\Mail;


use Support\Contracts\Mail\AbstractSendUsingMessageTemplateSystemId;

class MembershipWillAutoRenewIn30Days extends AbstractSendUsingMessageTemplateSystemId
{
    public function messageTemplateSystemId(): string
    {
        return "membership-will-auto-renew-in-thirty-days";
    }
}
