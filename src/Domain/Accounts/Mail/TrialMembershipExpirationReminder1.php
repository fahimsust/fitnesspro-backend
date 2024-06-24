<?php

namespace Domain\Accounts\Mail;


use Support\Contracts\Mail\AbstractSendUsingMessageTemplateSystemId;

class TrialMembershipExpirationReminder1 extends AbstractSendUsingMessageTemplateSystemId
{
    public function messageTemplateSystemId(): string
    {
        return "trial-reminder-1";
    }
}
