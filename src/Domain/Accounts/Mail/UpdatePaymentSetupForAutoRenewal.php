<?php

namespace Domain\Accounts\Mail;

use Support\Contracts\Mail\AbstractSendUsingMessageTemplateSystemId;

class UpdatePaymentSetupForAutoRenewal extends AbstractSendUsingMessageTemplateSystemId
{
    public function messageTemplateSystemId(): string
    {
        return "update-auto-renew-payment-settings";
    }
}
